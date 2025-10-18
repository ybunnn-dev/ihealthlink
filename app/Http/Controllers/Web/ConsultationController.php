<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Consultation;
use App\Models\ConsultationData;
use App\Models\EnrolledResident;
use App\Models\MedicineDistribution;
use App\Models\MedicineInventory;
use App\Models\BasicHealthRecord;
use App\Models\Resident;
use App\Models\HealthSigns;
use App\Models\ResidentMedicalHistory;
use App\Models\ResidentFamilyHistory;
use App\Models\RiskAssessment;
use App\Models\NcdRiskFactor;
use App\Models\PhilpenManagement;

use Carbon\Carbon;

class ConsultationController extends Controller
{
    public function getConsultation($id)
    {
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $consultation = Consultation::with([
            'consultationData',
            'medicineDistributions.medicine',
            'updatedBy:id,firstName,middleName,lastName,suffix', 
        ])->findOrFail($id);

        $consultationArray = $consultation->toArray();

        // Add full_name safely
        if ($consultation->updatedBy) {
            $consultationArray['updatedBy']['full_name'] = trim("{$consultation->updatedBy->firstName} {$consultation->updatedBy->middleName} {$consultation->updatedBy->lastName} {$consultation->updatedBy->suffix}");
            $consultationArray['updatedBy']['full_name'] = preg_replace('/\s+/', ' ', $consultationArray['updatedBy']['full_name']);
        }


        
        return response()->json([
            'consultation_data' => $consultationArray
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }
        $payload = $request->all();

        // 1. Find consultation
        $consultation = Consultation::findOrFail($payload['consultation_id']);
        if (!$consultation->enrolled_resident_id) {
            return response()->json(['error' => 'Consultation not linked to enrolled resident'], 400);
        }

        // 2. Update consultation
        $consultation->update([
            'status' => 'completed',
            'updated_by' => auth()->id(),
        ]);

        // 3. Update or create consultation data
        ConsultationData::updateOrCreate(
            ['consultation_id' => $consultation->id],
            [
                'chief_complaint' => $payload['chief_complaint'],
                'treatment' => $payload['treatment'],
                'weight' => $payload['weight'],
                'height' => $payload['height'],
                'bp_systolic' => $payload['bp_systolic'],
                'bp_diastolic' => $payload['bp_diastolic'],
                'rr' => $payload['rr'],
                'temperature' => $payload['temperature'],
                'pr' => $payload['pr'],
            ]
        );

        // 4. Handle medicine distributions
        foreach ($payload['distributed_medicines'] as $medicine) {
            $remainingQty = $medicine['quantity'];

            // Create a distribution record
            MedicineDistribution::create([
                'medicine_id' => $medicine['id'],
                'distributed_by' => auth()->id(),
                'consultation_id' => $consultation->id,
                'quantity' => $medicine['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Reduce inventory using Eloquent
            $batches = MedicineInventory::where('medicine_id', $medicine['id'])
                ->whereDate('expiry_date', '>', now()->addMonth())
                ->orderBy('expiry_date', 'asc')
                ->get();

            foreach ($batches as $batch) {
                if ($remainingQty <= 0) break;

                if ($batch->stock >= $remainingQty) {
                    $batch->stock -= $remainingQty;
                    $batch->save();
                    $remainingQty = 0;
                } else {
                    $remainingQty -= $batch->stock;
                    $batch->stock = 0;
                    $batch->save();
                }
            }
        }

        // 5. Check enrolled resident status
        $enrolledResident = EnrolledResident::find($consultation->enrolled_resident_id);
        $allCompleted = Consultation::where('enrolled_resident_id', $enrolledResident->id)
            ->where('status', '!=', 'completed')
            ->count() === 0;

        if ($allCompleted) {
            $enrolledResident->update(['status' => 'completed']);
        }

        $basicHR = BasicHealthRecord::firstOrCreate([
            'resident_id' => $consultation->resident_id,
        ]);

       // Prepare update data — only include non-null values
        $updateData = array_filter([
            'weight' => $payload['weight'] ?? null,
            'height' => $payload['height'] ?? null,
            'systolic_pressure' => $payload['bp_systolic'] ?? null,
            'diastolic_pressure' => $payload['bp_diastolic'] ?? null,
            'is_pregnant' => $payload['is_pregnant'] ?? null,
            'is_lactating' => $payload['is_lactating'] ?? null,
        ], fn($value) => !is_null($value));

        // Update only if there’s something to update
        if (!empty($updateData)) {
            $basicHR->update($updateData);
        }

        return response()->json(['message' => 'Consultation updated successfully']);
    }

   public function createPhilpenData(Request $request)
    {
        \Log::info($request->all());

        try {
            \DB::beginTransaction();

            // 1. Find or create consultation record
            $consultation = Consultation::findOrFail($request->consultation);

            // 2. Create/Update Health Signs (Red Flags)
            HealthSigns::updateOrCreate(
                ['resident_id' => $consultation->resident_id],
                [
                    'chest_pain' => $request->redFlags['chestPain'] ?? false,
                    'difficulty_in_breathing' => $request->redFlags['breathingDifficulty'] ?? false,
                    'loss_of_consciousness' => $request->redFlags['lossOfConsciousness'] ?? false,
                    'numbness_of_arm' => $request->redFlags['numbArm'] ?? false,
                    'act_of_self_harm_or_suicide' => $request->redFlags['selfHarm'] ?? false,
                    'agitated_or_aggressive_behavior' => $request->redFlags['aggressiveBehavior'] ?? false,
                    'severe_injuries' => $request->redFlags['severeInjuries'] ?? false,
                    'slurred_speech' => $request->redFlags['slurredSpeech'] ?? false,
                    'facial_asymmetry' => $request->redFlags['facialAsymmetry'] ?? false,
                    'chest_retractions' => $request->redFlags['chestRetractions'] ?? false,
                    'seizure_or_convulsion' => $request->redFlags['seizure'] ?? false,
                    'disoriented_as_to_time_place_or_person' => $request->redFlags['disoriented'] ?? false,
                    'eye_injury' => $request->redFlags['eyeInjury'] ?? false,
                ]
            );

            // 3. Create/Update Medical History
            ResidentMedicalHistory::updateOrCreate(
                ['resident_id' => $consultation->resident_id],
                [
                    'hypertension' => $request->medicalHistory['hypertension'] ?? false,
                    'heart_diseases' => $request->medicalHistory['heartDiseases'] ?? false,
                    'copd' => $request->medicalHistory['copd'] ?? false,
                    'surgical_history' => $request->medicalHistory['surgicalHistory'] ?? false,
                    'allergies' => $request->medicalHistory['allergies'] ?? false,
                    'diabetes' => $request->medicalHistory['diabetes'] ?? false,
                    'cancer' => $request->medicalHistory['cancer'] ?? false,
                    'asthma' => $request->medicalHistory['asthma'] ?? false,
                    'kidney_disorders' => $request->medicalHistory['kidneyDisorders'] ?? false,
                    'vision_problems' => $request->medicalHistory['visionProblems'] ?? false,
                    'thyroid_disorders' => $request->medicalHistory['thyroidDisorders'] ?? false,
                    'mental_neuro_substance_disorders' => $request->medicalHistory['mentalDisorders'] ?? false,
                ]
            );

            // 4. Create/Update Family History
            ResidentFamilyHistory::updateOrCreate(
                ['resident_id' => $consultation->resident_id],
                [
                    'hypertension' => $request->familyHistory['hypertension'] ?? false,
                    'heart_diseases' => $request->familyHistory['heartDiseases'] ?? false,
                    'copd' => $request->familyHistory['copd'] ?? false,
                    'tuberculosis_last_five_years' => $request->familyHistory['tuberculosis'] ?? false,
                    'stroke' => $request->familyHistory['stroke'] ?? false,
                    'diabetes_mellitus' => $request->familyHistory['diabetes'] ?? false,
                    'cancer' => $request->familyHistory['cancer'] ?? false,
                    'asthma' => $request->familyHistory['asthma'] ?? false,
                    'kidney_disorders' => $request->familyHistory['kidneyDisorders'] ?? false,
                    'premature_coronary_or_vascular_disease' => $request->familyHistory['coronaryDisease'] ?? false,
                    'mental_neurological_substance_abuse_disorders' => $request->familyHistory['mentalDisorders'] ?? false,
                ]
            );

            // 5. Create/Update NCD Risk Factors
            $ncdData = $request->ncdRiskFactors;
            NcdRiskFactor::updateOrCreate(
                [
                    'consultation_id' => $consultation->id,
                    'resident_id' => $consultation->resident_id
                ],
                [
                    'tobacco_use' => $ncdData['tobaccoStatus'] ?? null,
                    'alcohol_intake' => $ncdData['alcoholIntake'] ?? 0,
                    'caffeine_intake' => $ncdData['caffeineIntake'] ?? 0,
                    'high_fat_high_salt_food_intake' => $ncdData['nutrition'] ?? 0,
                    'street_foods_intake' => 0, // Not in request, default
                    'high_sugar_foods_intake' => 0, // Not in request, default
                    'number_of_drinks_last_year' => $ncdData['alcoholFrequency'] ?? 0,
                    'hours_of_activity_weekly' => $ncdData['physicalActivity'] ?? 0,
                    'weight' => $ncdData['weightKg'] ?? null,
                    'height' => $ncdData['heightCm'] ?? null,
                    'waist_circumference' => $ncdData['waistCm'] ?? null,
                    'systolic_pressure' => $ncdData['systolicBp'] ?? null,
                    'diastolic_pressure' => $ncdData['diastolicBp'] ?? null,
                ]
            );

            // 6. Create/Update Risk Assessment
            $bloodSugar = $request->riskAssessment['bloodSugar'];
            $lipidProfile = $request->riskAssessment['lipidProfile'];
            $urinalysis = $request->riskAssessment['urinalysis'];
            $copdSymptoms = $request->riskAssessment['copdSymptoms'];

            RiskAssessment::updateOrCreate(
                ['resident_id' => $consultation->resident_id],
                [
                    'polyphagia' => $bloodSugar['symptoms']['polyphagia'] ?? false,
                    'polydipsia' => $bloodSugar['symptoms']['polydipsia'] ?? false,
                    'polyuria' => $bloodSugar['symptoms']['polyuria'] ?? false,
                    'breathlessness' => $copdSymptoms['breathlessness'] ?? false,
                    'chronic_cough' => $copdSymptoms['chronicCough'] ?? false,
                    'sputum_production' => $copdSymptoms['sputumProduction'] ?? false,
                    'wheezing' => $copdSymptoms['wheezing'] ?? false,
                    'fbs_result' => $bloodSugar['fbs'] ?? null,
                    'rbs_result' => $bloodSugar['rbs'] ?? null,
                    'total_cholesterol' => $lipidProfile['totalCholesterol'] ?? null,
                    'hdl' => $lipidProfile['hdl'] ?? null,
                    'ldl' => $lipidProfile['ldl'] ?? null,
                    'vldl' => $lipidProfile['vldl'] ?? null,
                    'triglyceride' => $lipidProfile['triglyceride'] ?? null,
                    'protein' => $urinalysis['protein'] ?? null,
                    'ketones' => $urinalysis['ketones'] ?? null,
                    'blood_sugar_date_taken' => $bloodSugar['dateTaken'] ?: null,
                    'lipid_profile_date_taken' => $lipidProfile['dateTaken'] ?: null,
                    'urinalysis_date_taken' => $urinalysis['dateTaken'] ?: null,
                ]
            );

            // 7. Create/Update Philpen Management
            $management = $request->management;
            PhilpenManagement::updateOrCreate(
                ['consultation_id' => $consultation->id],
                [
                    'is_lifestyle_modification' => !empty($management['lifestyleModification']),
                    'is_anti_hypertensive' => !empty($management['medications']['antiHypertensive']),
                    'is_insulin' => !empty($management['medications']['oralHypoglycemic']),
                    'follow_up_date' => $management['followUpDate'] ?: null,
                    'remarks' => $management['remarks'] ?? null,
                ]
            );

            \DB::commit();

            return response()->json([
                'message' => 'Philpen record created successfully.',
                'data' => [
                    'consultation_id' => $consultation->id,
                    'resident_id' => $consultation->resident_id
                ]
            ], 201);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Philpen data creation failed: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Failed to create Philpen record.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
