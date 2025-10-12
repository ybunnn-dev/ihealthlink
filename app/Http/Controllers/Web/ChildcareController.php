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
use App\Models\ActivityLog;
use Illuminate\Support\Str;

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


    public function updateChildRecord(Request $request)
    {
        try {
            $user = auth()->user();

            // Determine if user is Midwife or BHW with granted access
            if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
                $personnel = $user->bhwWeb;
            } else {
                $personnel = $user->midwife;
            }

            if (!$personnel) {
                abort(403, 'Unauthorized access.');
            }
            $payload = (object) $request->all();

            $childCareId = $payload->importantIds['child_care_id'] ?? null;
            $enrolledResidentId = $payload->importantIds['enrolled_resident_id'] ?? null;

            if (!$childCareId || !$enrolledResidentId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Missing important IDs (child_care_id or enrolled_resident_id).'
                ], 400);
            }

            // Update Child Immunization Record
            $childCare = ChildHealthcare::find($childCareId);
            if ($childCare) {
                $atBirth = $payload->atBirth ?? [];
                $exclusive = $payload->nutrition['exclusiveBreastfeeding'] ?? [];
                $nutrition = $payload->nutrition ?? [];

                $childCare->birth_weight = $atBirth['birthWeightKg'] ?? null;
                $childCare->initiated_breast_feed = $atBirth['initiatedBreastfeeding'] ?? null;

                // Exclusive breastfeeding flags
                $childCare->is_exclusive_breastfeed_1 = $exclusive['at1_5months']['status'] === 'yes' ? 1 : 0;
                $childCare->is_exclusive_breastfeed_2 = $exclusive['at2_5months']['status'] === 'yes' ? 1 : 0;
                $childCare->is_exclusive_breastfeed_3 = $exclusive['at3_5months']['status'] === 'yes' ? 1 : 0;
                $childCare->is_exclusive_breastfeed_4 = $exclusive['at4_5months']['status'] === 'yes' ? 1 : 0;

                $childCare->exclusive_breastfeed_date_1 = $exclusive['at1_5months']['date'] ?? null;
                $childCare->exclusive_breastfeed_date_2 = $exclusive['at2_5months']['date'] ?? null;
                $childCare->exclusive_breastfeed_date_3 = $exclusive['at3_5months']['date'] ?? null;
                $childCare->exclusive_breastfeed_date_4 = $exclusive['at4_5months']['date'] ?? null;

                $childCare->is_exclusive_breastfeed_6mos = $exclusive['statusAt6Months'] === 'yes' ? 1 : 0;
                $childCare->stopped_exclusive_breastfeed_date = $exclusive['dateStopped'] ?? null;

                // Complementary feeding
                $complementary = $nutrition['complementaryFeedingStarted'] ?? null;
                if (!empty($complementary)) {
                    $childCare->complementary_feeding_status = $complementary;
                } else {
                    $childCare->complementary_feeding_status = null;
                }

                // FIC & CIC dates
                $childCare->fic_date = $payload->immunizations['ficDate'] ?? null;
                $childCare->cic_date = $payload->immunizations['cicDate'] ?? null;
                $childCare->remarks = $payload->remarks ?? null;
                $childCare->save();
            }

            $childName = $payload->basicInfo['fullName'] ?? 'Child Record';
            $childNameSlug = Str::slug($childName);

            $activityLog = ActivityLog::create([
                'user_id' => $user->id,
                'module_id' => 5,
                'activity' => 'Updated the child healthcare and immunization record of ' . $childName,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Childcare and enrolled resident updated successfully.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating childcare record: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating childcare record.',
            ], 500);
        }
    }
}
