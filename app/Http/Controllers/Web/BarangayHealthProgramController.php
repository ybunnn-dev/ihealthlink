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
use App\Models\FamilyPlanningData;


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
                 $q->where('category', 'tetanus_tcl');
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

        }else if($enrolledResident->program && $enrolledResident->program->category === 'family_planning_tcl'){
            $enrolledResident->load('famPlanRecord');

        }else if ($enrolledResident->program && $enrolledResident->program->category === 'philpen_tcl') {
            $enrolledResident->load([
                'consultations.ncdRiskFactor',
                'consultations.philpenManagement',
                'consultations.healthSigns',
                'consultations.medicalHistory',
                'consultations.familyHistory',
                'consultations.riskAssessment',
                'consultations.ncdRiskFactor',
                'consultations.philpenManagement',
            ]);
        }if ($enrolledResident->program && $enrolledResident->program->category === 'child_healthcare_tcl') {
            $enrolledResident->load([
                'childHealthcare.mother' // Nested eager load
            ]);

            // Access the mother easily
            $mother = $enrolledResident->childHealthcare?->mother;

            $antiTetanusEnrollment = EnrolledResident::where('resident_id', $enrolledResident->childHealthcare->mother_id)
            ->whereHas('program', function ($q) {
                $q->where('category', 'tetanus_tcl');
            })
            ->with([
                'consultations' => function ($q) {
                    $q->with('consultationData');
                },
                'program'
            ])
            ->first();

            $mother->setRelation('antiTetanusEnrollment', $antiTetanusEnrollment);

        }

        return view('midwife.enrolled-resident', compact('enrolledResident'));
    }


    public function getAllPrograms(Request $request)
    {
        $personnel = Auth::user()->midwife;
        $barangayId = $personnel->brgy_id;

        $query = HealthProgram::withCount(['enrolledResidents' => function ($q) use ($barangayId) {
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

    public function updateFamPlan(Request $request, $enrolledResident)
    {
        // Validate input
        $validated = $request->validate([
            'client_type' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'previous_method' => 'nullable|string|max:255',
            'dropout_date' => 'nullable|date',
            'dropout_reason' => 'nullable|string|max:255',
        ]);

        // Find the existing family planning data for this enrolled resident
        $familyPlanning = FamilyPlanningData::where('enrolled_resident_id', $enrolledResident)->first();

        if (!$familyPlanning) {
            return response()->json([
                'message' => 'Family planning record not found for the given enrolled resident.',
                'result' => 'error'
            ], 404);
        }

        // Update with the validated data
        $familyPlanning->update($validated);

        // If dropout_date is not null → mark as terminated
        if (!empty($validated['dropout_date'])) {
            $enrolledResidentModel = $familyPlanning->enrolledResident;

            if ($enrolledResidentModel) {
                // Update the status of the enrolled resident
                $enrolledResidentModel->update(['status' => 'terminated']);

                // Update all pending consultations to terminated
                $enrolledResidentModel->consultations()
                    ->where('status', 'pending')
                    ->update(['status' => 'terminated']);
            }
        }

        return response()->json([
            'message' => 'Family planning record updated successfully.',
            'result' => 'success',
            'updated_record' => $familyPlanning
        ]);
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
            ->where('status', 'pending')
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

    public function enrollFamPlan(Request $request, $residentId)
    {
        \Log::info('Family Planning Enrollment Data:', [
            'resident_id' => $residentId,
            'payload' => $request->all(),
        ]);

        // Retrieve from the JSON body
        $healthProgramId = $request->input('program_id');

        // Create the enrollment record
        $enrollment = EnrolledResident::create([
            'resident_id' => $residentId,
            'program_id' => $healthProgramId,
            'enrolled_by' => auth()->id(), // or manually set if this is a barangay user
            'status' => 'active', // default
        ]);

        FamilyPlanningData::create([
            'client_type' => $request->client_type,
            'source' => $request->source_select,
            'previous_method' => $request->previous_method,
            'enrolled_resident_id' => $enrollment->id, // if created earlier
        ]);

        $this->createConsultationSchedules($residentId, $healthProgramId, $enrollment->id);

        return response()->json([
            'message' => 'Resident successfully enrolled in the program.',
            'result' => 'success',
            'enrollment' => $enrollment,
        ]);
    }

   protected function createConsultationSchedules($residentId, $programId, $enrolledResident)
    {
        $fields = ProgramSchedule::where('program_id', $programId)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();

        if ($fields->isEmpty()) {
            \Log::warning("No program fields found for program {$programId}");
            return;
        }

        $consultations = [];
        $currentDate = Carbon::now(); // start from today
        $isFirst = true;

        foreach ($fields as $field) {
            // Only add interval for subsequent consultations
            if (!$isFirst) {
                $currentDate = $currentDate->copy()->addDays($field->interval_days);
            }

            $consultations[] = [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrolledResident,
                'consultation_date' => $currentDate,
                'status' => 'pending',
                'consultation_title' => $field->title,
                'schedule_extension_days' => $field->extension_days,
                'remarks' => null,
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $isFirst = false;
        }

        Consultation::insert($consultations);

        \Log::info("Consultation schedules created", [
            'resident_id' => $residentId,
            'program_id' => $programId,
            'count' => count($consultations),
        ]);
    }
}
