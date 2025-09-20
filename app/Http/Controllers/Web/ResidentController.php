<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Resident;
use App\Models\HealthSigns;
use App\Models\ResidentMedicalHistory;
use App\Models\ResidentFamilyHistory;

class ResidentController extends Controller
{
    public function addResident(Request $request)
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
        // If valid
        return response()->json([
            'status' => 'success',
            'message' => 'Data is valid',
            'data' => $validator->validated() // optional: return validated data
        ]);
    }
}
