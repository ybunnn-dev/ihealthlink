<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

use App\Models\Consultation;
use App\Models\ProgramSchedule;
use App\Models\HealthProgram;
use App\Models\EnrolledResident;
use App\Models\BasicHealthRecord;
use App\Models\ChildHealthcare;
use App\Models\Resident;

class ChildcareController extends Controller
{
    public function enrollChild(Request $request)
    {
        try {
            // Validate inputs
            $validated = $request->validate([
                'resident_id' => 'required|integer|exists:residents,id',
                'mother_id' => 'required|integer|exists:residents,id',
                'birthWeight' => 'required|numeric|min:0',
                'program_id' => 'required|integer|exists:health_programs,id',
            ]);

            $residentId = $validated['resident_id'];
            $programId = $validated['program_id'];
            $motherId = $validated['mother_id'];
            $birthWeight = $validated['birthWeight'];
            $userId = Auth::id();

            // Determine personnel: BHW with role 4 or Midwife
            $user = auth()->user();

            if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
                $personnel = $user->bhwWeb;
            } else {
                $personnel = $user->midwife;
            }

            if (!$personnel) {
                abort(403, 'Unauthorized access.');
            }

            // Check if resident is already enrolled in this program
            $alreadyEnrolled = EnrolledResident::where('resident_id', $residentId)
                ->where('program_id', $programId)
                ->exists();

            if ($alreadyEnrolled) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Resident is already enrolled in this program.'
                ], 422);
            }

            // Get resident data to access birthdate (auto-decrypted by model)
            $resident = Resident::findOrFail($residentId);
            $birthdate = $resident->birthdate;

            $basicHealthRecord = BasicHealthRecord::where('resident_id', $validated['resident_id'])->first();
            
            
            // Create enrolled resident
            $enrolledResident = EnrolledResident::create([
                'resident_id' => $residentId,
                'program_id' => $programId,
                'enrolled_by' => $userId,
                'status' => 'active',
            ]);

            // Create child healthcare record
            $childHealthcare = ChildHealthcare::create([
                'enrolled_resident_id' => $enrolledResident->id,
                'mother_id' => $motherId,
                'birth_weight' => $birthWeight,
            ]);


            // Create consultation schedules
            $this->createChildConsultationSchedules($residentId, $enrolledResident->id, $birthdate);

            // Optionally, log child-specific data if you have a child health table
           

            return response()->json([
                'status' => 'success',
                'message' => 'Resident enrolled successfully.',
                'data' => $enrolledResident
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error enrolling child:', ['message' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
            ], 500);
        }
    }

    protected function createChildConsultationSchedules($residentId, $enrollId, $birthdate)
    {
        $birthdate = \Carbon\Carbon::parse($birthdate);

        $consultations = [
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(28), // Within 28 Days
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Within 28 Days Old',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(45), // 1 1/2 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '1 1/2 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(75), // 2 1/2 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '2 1/2 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(105), // 3 1/2 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '3 1/2 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(120), // 4 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '4 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(150), // 5 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '5 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(180), // 6 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '6 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(210), // 7 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '7 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(270), // 9 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '9 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $birthdate->copy()->addDays(365), // 12 months
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => '12 Months',
                'remarks' => null,
                'updated_by' => null,
            ],
        ];

        // Insert all consultations at once
        Consultation::insert($consultations);
    }
}
