<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BasicMaternalRecord;
use App\Models\EnrolledResident;
use App\Models\Consultation;
use App\Models\BasicHealthRecord;
use App\Models\MaternityScreening;
use App\Models\PregnancyOutcome;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MaternalController extends Controller
{   
    public function updateMaternalRecord(Request $request)
    {
        $data = $request->all();
        Log::info('Maternal record update payload:', $data);

        $maternalRecordId = $data['imporantIds']['maternalRecordId'] ?? null;

        if (!$maternalRecordId) {
            return response()->json([
                'message' => 'Maternal Record ID is required.'
            ], 400);
        }

        try {
            /*
            |--------------------------------------------------------------------------
            | Update or Create Pregnancy Outcome
            |--------------------------------------------------------------------------
            */
            $outcomeData = $data['pregnancyOutcome'] ?? [];
            $deliveryInfo = $data['deliveryInfo'] ?? [];

            $pregnancyOutcome = PregnancyOutcome::firstOrNew([
                'basic_maternal_record_id' => $maternalRecordId,
            ]);

            $pregnancyOutcome->date_terminated           = $outcomeData['dateTerminated'] ?? null;
            $pregnancyOutcome->outcome                   = $outcomeData['outcome'] ?? null;
            $pregnancyOutcome->sex                       = $outcomeData['sex'] ?? null;
            $pregnancyOutcome->delivery_type             = $outcomeData['typeOfDelivery'] ?? null;
            $pregnancyOutcome->birth_weight              = $outcomeData['birthWeightKg'] ?? null;
            $pregnancyOutcome->delivery_place_type       = $deliveryInfo['place']['healthFacilityType'] ?? null;
            $pregnancyOutcome->is_bemonc_cemonc_capable  = $deliveryInfo['place']['isBemmoncCemoncCapable'] ?? null;
            $pregnancyOutcome->delivery_place_ownership  = $deliveryInfo['place']['facilityOwnership'] ?? null;
            $pregnancyOutcome->birth_attendant           = $deliveryInfo['place']['birthAttendant'] ?? null;
            $pregnancyOutcome->remarks                   = $deliveryInfo['place']['remarks'] ?? null;

            if (!empty($deliveryInfo['dateTime']['date']) && !empty($deliveryInfo['dateTime']['time'])) {
                $pregnancyOutcome->delivery_datetime = $deliveryInfo['dateTime']['date'] . ' ' . $deliveryInfo['dateTime']['time'];
            }

            if (!empty($deliveryInfo['dateTime']['date'])) {
                $this->updateConsultations($data['imporantIds']['enrolledResidentId'], $deliveryInfo['dateTime']['date']);
            }
            $pregnancyOutcome->save();

            $screeningData = $data['labAndDiseaseScreening'] ?? [];
            $infectious = $screeningData['infectiousDisease'] ?? [];
            $laboratory = $screeningData['laboratory'] ?? [];

            $maternityScreening = MaternityScreening::firstOrNew([
                'maternal_record_id' => $maternalRecordId,
            ]);

            $maternityScreening->syphilis_screening_date             = $infectious['syphilis']['date'] ?? null;
            $maternityScreening->syphilis_screening_result           = $infectious['syphilis']['result'] ?? null;
            $maternityScreening->hepatitis_b_screening_date          = $infectious['hepatitisB']['date'] ?? null;
            $maternityScreening->hepatitis_b_screening_result        = $infectious['hepatitisB']['result'] ?? null;
            $maternityScreening->hiv_screening_date                  = $infectious['hiv']['date'] ?? null;
            $maternityScreening->hiv_screening_result                = $infectious['hiv']['result'] ?? null;
            $maternityScreening->gestational_diabetes_screening_date = $laboratory['gestationalDiabetes']['date'] ?? null;
            $maternityScreening->gestational_diabetes_result         = $laboratory['gestationalDiabetes']['result'] ?? null;
            $maternityScreening->cbc_screening_date                  = $laboratory['cbc']['date'] ?? null;
            $maternityScreening->cbc_result                          = $laboratory['cbc']['result'] ?? null;
            $maternityScreening->given_iron                          = $laboratory['cbc']['givenIron'] ?? null;

            $maternityScreening->save();

           
            $maternalRecord = BasicMaternalRecord::firstOrNew([
                'id' => $maternalRecordId,
            ]);

            \Log::info($data['remarks']);
            $maternalRecord->remarks = $data['remarks']['general'] ?? null;

            $maternalRecord->save();
            /*
            |--------------------------------------------------------------------------
            | Return Successful Response
            |--------------------------------------------------------------------------
            */
            return response()->json([
                'message' => 'Maternal record updated successfully.',
                'pregnancyOutcome' => $pregnancyOutcome,
                'maternityScreening' => $maternityScreening,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Maternal record update failed:', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred while updating maternal record.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function updateConsultations($enrolledResidentIdRecordId, $deliveryDate)
    {
        Log::info('Fetching consultations for enrolled resident ID: ' . $enrolledResidentIdRecordId);

        $consultations = Consultation::where('enrolled_resident_id', $enrolledResidentIdRecordId)->get();

        if ($consultations->isEmpty()) {
            Log::info('No consultations found for this enrolled resident.');
            return;
        }

        Log::info('Consultations found:', $consultations->toArray());
        Log::info('Delivery date: ' . $deliveryDate);

        // Parse delivery date
        $delivery = Carbon::parse($deliveryDate);

        // Define postpartum schedule intervals
        $postpartumSchedules = [
            'Postpartum (within 24h)' => $delivery->copy()->addHours(24),
            'Postpartum (within 7 days)' => $delivery->copy()->addDays(7),
            'Postpartum (1 month)' => $delivery->copy()->addMonth(),
            'Postpartum (2 months)' => $delivery->copy()->addMonths(2),
            'Postpartum (3 months)' => $delivery->copy()->addMonths(3),
        ];

        foreach ($consultations as $consultation) {
            if (isset($postpartumSchedules[$consultation->consultation_title])) {
                $newDate = $postpartumSchedules[$consultation->consultation_title];
                $consultation->consultation_date = $newDate;
                $consultation->save();

                Log::info("Updated {$consultation->consultation_title} to {$newDate->toDateString()}");
            }
        }

        Log::info('Postpartum consultations successfully updated.');
    }

    public function enroll(Request $request)
    {
        $validated = $request->validate([
            'health_program_id' => 'required|integer|exists:health_programs,id',
            'resident_id' => 'required|integer|exists:residents,id',
            'last_menstrual_period' => 'required|date',
            'expected_date_of_confinement' => 'required|date|after:last_menstrual_period',
            'gravida' => 'required|integer|min:0',
            'para' => 'required|integer|min:0|lte:gravida',
        ]);

        // Step 1: Enroll the resident into the program
        $enrollment = EnrolledResident::create([
            'resident_id' => $validated['resident_id'],
            'program_id' => $validated['health_program_id'],
            'enrolled_by' => auth()->id(),
            'status' => 'active',
        ]);

        // Step 2: Create basic maternal record linked to enrolled resident
        $record = BasicMaternalRecord::create([
            'enrolled_resident_id' => $enrollment->id,
            'last_menstrual_period' => $validated['last_menstrual_period'],
            'expected_date_of_confinement' => $validated['expected_date_of_confinement'],
            'gravida' => $validated['gravida'],
            'para' => $validated['para'],
        ]);

        $this->createConsultationSchedules(
            $validated['resident_id'],
            $enrollment->id,
            $validated['last_menstrual_period']
        );

        $basicHealthRecord = BasicHealthRecord::where('resident_id', $validated['resident_id'])->first();

         if ($basicHealthRecord) {
            $basicHealthRecord->update(['is_pregnant' => true]);
        }

        return response()->json([
            'message' => 'Maternal record enrolled successfully',
            'enrollment' => $enrollment,
            'maternal_record' => $record,
        ]);
    }

    protected function createConsultationSchedules($residentId, $enrollId, $lmp)
    {
        $lmp = \Carbon\Carbon::parse($lmp);

        $consultations = [
            // Trimester schedules
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $lmp->copy()->addWeeks(12),
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Trimester 1',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $lmp->copy()->addWeeks(24),
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Trimester 2',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $lmp->copy()->addWeeks(32),
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Trimester 3 (1)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $lmp->copy()->addWeeks(36),
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Trimester 3 (2)',
                'remarks' => null,
                'updated_by' => null,
            ],

            // Postpartum schedules (consultation_date = null)
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (within 24h)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (within 7 days)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (1 month)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (2 months)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (3 months)',
                'remarks' => null,
                'updated_by' => null,
            ],
        ];
        Consultation::insert($consultations);
    }
}
