<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Consultation;
use App\Models\ProgramSchedule;
use App\Models\HealthProgram;
use App\Models\EnrolledResident;
use App\Models\BasicHealthRecord;


use Illuminate\Support\Facades\Auth;
class BarangayHealthProgramController extends Controller
{
    public function index(HealthProgram $healthProgram = null)
    {
        $personnel = Auth::user()->midwife;
        $barangayId = $personnel->brgy_id; 

        if (!$healthProgram) {
            $healthProgram = HealthProgram::latest()->first();
        }

        // Get enrolled residents for this health program and midwife's barangay
        $enrolledResidents = EnrolledResident::with(['consultations' => function ($q) {
                $q->orderBy('consultation_date'); // optional: sort consultations
            }])
            ->where('program_id', $healthProgram->id)
            ->whereHas('resident.family.household.purok', function ($q) use ($barangayId) {
                $q->where('brgy_id', $barangayId);
            })
            ->get();

        // Filter consultations to only those matching the enrolled resident
        $enrolledResidents->each(function ($enrollment) {
            $enrollment->consultations = $enrollment->consultations
                ->where('enrolled_resident_id', $enrollment->id);
        });

        $totalEnrolled = $enrolledResidents->count();

        $completed = $enrolledResidents->where('status', 'completed')->count();

        $overdue = $enrolledResidents->filter(function ($enrollment) {
            return $enrollment->resident->consultations->contains(function ($consultation) {
                return $consultation->status === 'pending'
                    && \Carbon\Carbon::parse($consultation->consultation_date)->isBefore(\Carbon\Carbon::today());
            });
        })->count();

        return view('midwife.health-program', compact(
            'healthProgram',
            'enrolledResidents',
            'totalEnrolled',
            'completed',
            'overdue'
        ));
    }

    public function show(EnrolledResident $enrolledResident)
    {
        // Load main enrolled resident relationships
        $enrolledResident->load([
            'consultations' => function ($q) use ($enrolledResident) {
                $q->where('enrolled_resident_id', $enrolledResident->id)
                ->with('consultationData')
                ->with('medicineDistributions.medicine');
            },
            'resident.family.household.purok.barangay',
            'resident.basicHealthRecord',
            'program'
        ]);

        // If the current program is maternal health TCL
        if ($enrolledResident->program && $enrolledResident->program->category === 'maternal_health_tcl') {

            // Load maternal record details
            $enrolledResident->load('maternalRecord', 'maternalRecord.maternityScreening', 'maternalRecord.pregnancyOutcome');

            $antiTetanusEnrollment = EnrolledResident::where('resident_id', $enrolledResident->resident_id)
            ->whereHas('program', function ($q) {
                $q->where('name', 'Anti-Tetanus Vaccination');
            })
            ->with([
                'consultations' => function ($q) {
                    $q->with('consultationData');
                },
                'program'
            ])
            ->first();

            // Attach to current enrolled resident instance
            $enrolledResident->setRelation('antiTetanusEnrollment', $antiTetanusEnrollment);
        }

        return view('midwife.enrolled-resident', compact('enrolledResident'));
    }


    public function getAllPrograms(Request $request)
    {
        $personnel = Auth::user()->midwife;
        $barangayId = $personnel->brgy_id;

        $query = HealthProgram::with(['enrolledResidents' => function ($q) use ($barangayId) {
            $q->whereHas('resident.family.household.purok', function ($sub) use ($barangayId) {
                $sub->where('brgy_id', $barangayId);
            });
        }]);

        // Search by program name (optional)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by category (optional)
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category', $category);
        }

        $programs = $query->get();

        return response()->json($programs);
    }


    public function enrollResident(Request $request, $healthProgramId, $residentId)
    {
        // Validate program and resident existence
        $validator = Validator::make(
            ['healthProgramId' => $healthProgramId, 'residentId' => $residentId],
            [
                'healthProgramId' => 'required|integer|exists:health_programs,id',
                'residentId' => 'required|integer|exists:residents,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if already enrolled
        $alreadyEnrolled = EnrolledResident::where('program_id', $healthProgramId)
            ->where('resident_id', $residentId)
            ->exists();

        if ($alreadyEnrolled) {
            return response()->json([
                'message' => 'Resident is already enrolled in this program',
            ], 409);
        }

        // Enroll the resident
        $enrollment = EnrolledResident::create([
            'resident_id' => $residentId,
            'program_id' => $healthProgramId,
            'enrolled_by' => auth()->id(), // current user, adjust if needed
            'status' => 'active', // default status
        ]);

        $this->createConsultationSchedules($residentId, $healthProgramId, $enrollment->id);

        return response()->json([
            'message' => 'Resident enrolled successfully',
            'data' => $enrollment,
        ], 201);
    }

    protected function createConsultationSchedules($residentId, $programId, $enrolledResident)
    {
        // Fetch program fields in order
        $fields = ProgramSchedule::where('program_id', $programId)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();

        if ($fields->isEmpty()) {
            \Log::warning("No program fields found for program {$programId}");
            return;
        }

        $consultations = [];
        $currentDate = Carbon::now(); // start from today, you can adjust

        foreach ($fields as $field) {
            $currentDate = $currentDate->copy()->addDays($field->interval_days);

            $consultations[] = [
                'resident_id' => $residentId,
                'enrolled_resident_id'    => $enrolledResident,
                'consultation_date'  => $currentDate,
                'status'             => 'pending',
                'consultation_title' => $field->title,
                'schedule_extension_days' => $field->extension_days,
                'remarks'            => null,
                'updated_by'         => auth()->id(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        }

        Consultation::insert($consultations);

        \Log::info("Consultation schedules created", [
            'resident_id' => $residentId,
            'program_id' => $programId,
            'count' => count($consultations),
        ]);
    }
}
