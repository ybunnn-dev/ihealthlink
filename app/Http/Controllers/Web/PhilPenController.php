<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhilPenController extends Controller
{
        /*public function addResident(Request $request)
    {
        $rules = [
            // Basic info
            'firstName'          => ['required', 'string', 'max:255'],
            'lastName'           => ['required', 'string', 'max:255'],
            'middleName'         => ['nullable', 'string', 'max:255'],
            'suffix'             => ['nullable', 'string', 'max:50'],
            'contactNo'          => ['nullable', 'string', 'max:20'],
            'birthDate'          => ['required', 'string'],
            'familyId'           => ['required', 'integer'],
            'familyRelationship' => ['required', 'string', 'max:255'],
            'civilStatus'        => ['required', 'string', 'max:255'],
            'religion'           => ['required', 'string', 'max:255'],
            'ethnicity'          => ['required', 'string'],
            'employmentStatus'   => ['required', 'string', 'max:255'],
            'isPWD'              => ['boolean'],
            'pwdIdInput'         => ['nullable', 'string', 'max:100'],
            'isIndegenous'       => ['boolean'],
            'emergencyContactNo' => ['nullable', 'string', 'max:20'],

            // Nested objects
            'redFlags'           => ['required', 'array'],
            'redFlags.*'         => ['boolean'],

            'medHistory'         => ['required', 'array'],
            'medHistory.*'       => ['boolean'],

            'familyHistory'      => ['required', 'array'],
            'familyHistory.*'    => ['boolean'],

            'ncd_factors'        => ['required', 'array'],
            'ncd_factors.tobaccoUse'        => ['nullable', 'string'],
            'ncd_factors.alcoholConsumption'=> ['nullable', 'string'],
            'ncd_factors.alcoholFrequency'  => ['nullable', 'string'],
            'ncd_factors.caffeineIntake'    => ['nullable', 'string'],
            'ncd_factors.physicalActivity'  => ['nullable', 'string'],
            'ncd_factors.weightKg'          => ['nullable', 'numeric'],
            'ncd_factors.heightCm'          => ['nullable', 'numeric'],
            'ncd_factors.bmi'               => ['nullable', 'numeric'],
            'ncd_factors.waistCircumferenceCm' => ['nullable', 'numeric'],
            'ncd_factors.bpSystolic'        => ['nullable', 'numeric'],
            'ncd_factors.bpDiastolic'       => ['nullable', 'numeric'],
            'ncd_factors.eatsHighFatFood'   => ['boolean'],
            'ncd_factors.eatsStreetFood'    => ['boolean'],
            'ncd_factors.eatsHighSugarFood' => ['boolean'],

            'risk_assessment'               => ['required', 'array'],
            'risk_assessment.bloodSugar'    => ['required', 'array'],
            'risk_assessment.bloodSugar.fbsResult' => ['nullable', 'numeric'],
            'risk_assessment.bloodSugar.rbsResult' => ['nullable', 'numeric'],
            'risk_assessment.bloodSugar.dateTaken' => ['nullable', 'string'],
            'risk_assessment.bloodSugar.hasPolyphagia' => ['boolean'],
            'risk_assessment.bloodSugar.hasPolydipsia' => ['boolean'],
            'risk_assessment.bloodSugar.hasPolyuria'   => ['boolean'],

            'risk_assessment.lipidProfile'  => ['required', 'array'],
            'risk_assessment.lipidProfile.totalCholesterol' => ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.hdl' => ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.ldl' => ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.vldl'=> ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.triglyceride' => ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.dateTaken' => ['nullable', 'string'],

            'risk_assessment.urinalysis'    => ['required', 'array'],
            'risk_assessment.urinalysis.protein' => ['nullable', 'string'],
            'risk_assessment.urinalysis.ketones' => ['nullable', 'string'],
            'risk_assessment.urinalysis.dateTaken' => ['nullable', 'string'],

            'risk_assessment.copdAssessment'=> ['required', 'array'],
            'risk_assessment.copdAssessment.hasBreathlessness' => ['boolean'],
            'risk_assessment.copdAssessment.hasChronicCough'   => ['boolean'],
            'risk_assessment.copdAssessment.hasSputum'         => ['boolean'],
            'risk_assessment.copdAssessment.hasWheezing'       => ['boolean'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Return message for frontend
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors() // detailed field errors
            ], 422);
        }

        $birthDate = Carbon::createFromFormat('m/d/Y', $request->birthDate)->format('Y-m-d');

        $resident = Resident::create([
            'family_id'           => $request->familyId,
            'added_by'            => auth()->id(), // optional if you track user
            'firstName'           => $request->firstName,
            'lastName'            => $request->lastName,
            'middleName'          => $request->middleName,
            'suffix'              => $request->suffix,
            'birthdate'           => $birthDate,
            'sex'                 => $request->sex, // if included
            'contact_no'          => $request->contactNo,
            'civil_status'        => $request->civilStatus,
            'family_relationship' => $request->familyRelationship,
            'is_pwd'              => $request->isPWD,
            'pwd_id'              => $request->pwdIdInput,
            'is_indigenous'       => $request->isIndegenous,
            'employment_status'   => $request->employmentStatus,
            'status'              => 'active', // default?
            'religion'            => $request->religion,
            'ethnicity'           => $request->ethnicity,
            'emergencyContactNo'  => $request->emergencyContactNo,
        ]);

        try {
            // Get the purok_id of the household where the family belongs
            $family = $resident->family; // from relationship
            $household = $family ? $family->household : null;
            $purokId = $household ? $household->purok_id : null;

            if ($purokId) {
                // Check if resident already has a residence history
                $existingHistory = ResidenceHistory::where('resident_id', $resident->id)
                    ->where('status', 'active')
                    ->first();

                // If there’s an active record, mark it as moved
                if ($existingHistory) {
                    $existingHistory->update([
                        'status' => 'moved',
                        'updated_at' => now(),
                    ]);
                    \Log::info("Updated previous residence history for resident ID {$resident->id} to 'moved'.");
                }

                // Create new active record
                ResidenceHistory::create([
                    'resident_id' => $resident->id,
                    'purok_id' => $purokId,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                \Log::info("Created new residence history for resident ID {$resident->id} with purok ID {$purokId}.");
            } else {
                \Log::warning("Could not determine purok_id for resident ID {$resident->id} (missing family/household relationship).");
            }
        } catch (\Exception $e) {
            Log::error("Error creating residence history for resident ID {$resident->id}: " . $e->getMessage());
        }
        // Save health signs (red flags)
        // map redFlags -> resident_health_signs
        if ($request->has('redFlags')) {
            $resident->healthSigns()->create([
                'chest_pain'                       => $request->redFlags['hasChestPain'] ?? null,
                'difficulty_in_breathing'          => $request->redFlags['hasBreathingDifficulty'] ?? null,
                'loss_of_consciousness'            => $request->redFlags['hasLossOfConsciousness'] ?? null,
                'numbness_of_arm'                  => $request->redFlags['hasNumbArm'] ?? null,
                'act_of_self_harm_or_suicide'      => $request->redFlags['hasSelfHarm'] ?? null,
                'agitated_or_aggressive_behavior'  => $request->redFlags['hasAggressiveBehavior'] ?? null,
                'severe_injuries'                  => $request->redFlags['hasSevereInjuries'] ?? null,
                'slurred_speech'                   => $request->redFlags['hasSlurredSpeech'] ?? null,
                'facial_asymmetry'                 => $request->redFlags['hasFacialAsymmetry'] ?? null,
                'chest_retractions'                => $request->redFlags['hasChestRetractions'] ?? null,
                'seizure_or_convulsion'            => $request->redFlags['hasSeizure'] ?? null,
                'disoriented_as_to_time_place_or_person' => $request->redFlags['isDisoriented'] ?? null,
                'eye_injury'                       => $request->redFlags['hasEyeInjury'] ?? null,
            ]);
        }

        // map medHistory -> resident_medical_history
        if ($request->has('medHistory')) {
            $resident->medicalHistory()->create([
                'hypertension'   => $request->medHistory['hasHypertension'] ?? null,
                'heart_diseases' => $request->medHistory['hasHeartDiseases'] ?? null,
                'copd'           => $request->medHistory['hasCopd'] ?? null,
                'surgical_history'=> $request->medHistory['hasSurgicalHistory'] ?? null,
                'allergies'      => $request->medHistory['hasAllergies'] ?? null,
                'diabetes'       => $request->medHistory['hasDiabetes'] ?? null,
                'cancer'         => $request->medHistory['hasCancer'] ?? null,
                'asthma'         => $request->medHistory['hasAsthma'] ?? null,
                'kidney_disorders' => $request->medHistory['hasKidneyDisorders'] ?? null,
                'vision_problems'  => $request->medHistory['hasVisionProblems'] ?? null,
                'thyroid_disorders'=> $request->medHistory['hasThyroidDisorders'] ?? null,
                'mental_neuro_substance_disorders' => $request->medHistory['hasMentalDisorders'] ?? null,
            ]);
        }

        if ($request->has('familyHistory')) {
            $resident->familyHistory()->create([
                'hypertension'    => $request->familyHistory['hasHypertension'] ?? null,
                'heart_diseases'  => $request->familyHistory['hasHeartDiseases'] ?? null,
                'copd'            => $request->familyHistory['hasCopd'] ?? null,
                'tuberculosis_last_five_years' => $request->familyHistory['hasTuberculosis'] ?? null,
                'stroke'          => $request->familyHistory['hasStroke'] ?? null,
                'diabetes_mellitus' => $request->familyHistory['hasDiabetes'] ?? null,
                'cancer'          => $request->familyHistory['hasCancer'] ?? null,
                'asthma'          => $request->familyHistory['hasAsthma'] ?? null,
                'kidney_disorders'=> $request->familyHistory['hasKidneyDisorders'] ?? null,
                'premature_coronary_or_vascular_disease' => $request->familyHistory['hasCoronaryDisease'] ?? null,
                'mental_neurological_substance_abuse_disorders' => $request->familyHistory['hasMentalDisorders'] ?? null,
            ]);
        }

        // --- 5. CREATE NCD RISK FACTOR ---
        if ($request->has('ncd_factors')) {
            $ncd = $request->ncd_factors;
            $resident->ncdRiskFactor()->create([
                'tobacco_use'     => $this->ynToBoolOrNull($ncd['tobaccoUse'] ?? null),
                'alcohol_intake'  => $this->ynToBoolOrNull($ncd['alcoholConsumption'] ?? null),
                'caffeine_intake' => $this->ynToBoolOrNull($ncd['caffeineIntake'] ?? null),
                'high_fat_high_salt_food_intake' => $ncd['eatsHighFatFood'] ?? false,
                'street_foods_intake'  => $ncd['eatsStreetFood'] ?? false,
                'high_sugar_foods_intake' => $ncd['eatsHighSugarFood'] ?? false,
                'number_of_drinks_last_year' => $ncd['alcoholFrequency'] ?? null,
                'hours_of_activity_weekly' => $ncd['physicalActivity'] ?? null,
                'weight'               => $ncd['weightKg'] ?? null,
                'height'               => $ncd['heightCm'] ?? null,
                'waist_circumference'  => $ncd['waistCircumferenceCm'] ?? null,
                'systolic_pressure'    => $ncd['bpSystolic'] ?? null,
                'diastolic_pressure'   => $ncd['bpDiastolic'] ?? null,
            ]);

            $resident->basicHealthRecord()->create([
                'weight' => $ncd['weightKg'] ?? null,
                'height' => $ncd['heightCm'] ?? null,
                'systolic_pressure'    => $ncd['bpSystolic'] ?? null,
                'diastolic_pressure'   => $ncd['bpDiastolic'] ?? null,
                'waist_circumference'  => $ncd['waistCircumferenceCm'] ?? null,
                'is_pregnant' => false,
                'is_lactating' => false,
                'weight_grams' => null,
                'status' => 'alive',
            ]);
        }

        
        if ($request->has('risk_assessment')) {
            $assessment = $request->risk_assessment;
            $bloodSugar = $assessment['bloodSugar'] ?? [];
            $lipid = $assessment['lipidProfile'] ?? [];
            $urinalysis = $assessment['urinalysis'] ?? [];
            $copd = $assessment['copdAssessment'] ?? [];

            $resident->riskAssessment()->create([
                // Blood Sugar Data
                'fbs_result'             => $bloodSugar['fbsResult'] ?? null,
                'rbs_result'             => $bloodSugar['rbsResult'] ?? null,
                'blood_sugar_date_taken' => isset($bloodSugar['dateTaken']) && $bloodSugar['dateTaken'] ? Carbon::createFromFormat('m/d/Y', $bloodSugar['dateTaken'])->format('Y-m-d') : null,
                'has_polyphagia'         => $bloodSugar['hasPolyphagia'] ?? false,
                'has_polydipsia'         => $bloodSugar['hasPolydipsia'] ?? false,
                'has_polyuria'           => $bloodSugar['hasPolyuria'] ?? false,

                // Lipid Profile Data
                'total_cholesterol'      => $lipid['totalCholesterol'] ?? null,
                'hdl'                    => $lipid['hdl'] ?? null,
                'ldl'                    => $lipid['ldl'] ?? null,
                'vldl'                   => $lipid['vldl'] ?? null,
                'triglyceride'           => $lipid['triglyceride'] ?? null,
                'lipid_profile_date_taken' => isset($lipid['dateTaken']) && $lipid['dateTaken'] ? Carbon::createFromFormat('m/d/Y', $lipid['dateTaken'])->format('Y-m-d') : null,

                // Urinalysis Data
                'protein'                => $urinalysis['protein'] ?? null,
                'ketones'                => $urinalysis['ketones'] ?? null,
                'urinalysis_date_taken'  => isset($urinalysis['dateTaken']) && $urinalysis['dateTaken'] ? Carbon::createFromFormat('m/d/Y', $urinalysis['dateTaken'])->format('Y-m-d') : null,

                // COPD Data
                'has_breathlessness'     => $copd['hasBreathlessness'] ?? false,
                'has_chronic_cough'      => $copd['hasChronicCough'] ?? false,
                'has_sputum'             => $copd['hasSputum'] ?? false,
                'has_wheezing'           => $copd['hasWheezing'] ?? false,
            ]);
        }
        // If valid
        return response()->json([
            'status' => 'success',
            'message' => 'Data is valid',
            'data' => $validator->validated() // optional: return validated data
        ]);
    }*/
}
