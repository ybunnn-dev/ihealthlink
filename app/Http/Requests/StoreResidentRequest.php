<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all for now
    }

    public function rules(): array
    {
        \Log::info('this is the only one showing in the log');
        return [
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

            // blood sugar
            'risk_assessment.bloodSugar'    => ['required', 'array'],
            'risk_assessment.bloodSugar.fbsResult' => ['nullable', 'numeric'],
            'risk_assessment.bloodSugar.rbsResult' => ['nullable', 'numeric'],
            'risk_assessment.bloodSugar.dateTaken' => ['nullable', 'string'],
            'risk_assessment.bloodSugar.hasPolyphagia' => ['boolean'],
            'risk_assessment.bloodSugar.hasPolydipsia' => ['boolean'],
            'risk_assessment.bloodSugar.hasPolyuria'   => ['boolean'],

            // lipid profile
            'risk_assessment.lipidProfile'  => ['required', 'array'],
            'risk_assessment.lipidProfile.totalCholesterol' => ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.hdl' => ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.ldl' => ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.vldl'=> ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.triglyceride' => ['nullable', 'numeric'],
            'risk_assessment.lipidProfile.dateTaken' => ['nullable', 'string'],

            // urinalysis
            'risk_assessment.urinalysis'    => ['required', 'array'],
            'risk_assessment.urinalysis.protein' => ['nullable', 'string'],
            'risk_assessment.urinalysis.ketones' => ['nullable', 'string'],
            'risk_assessment.urinalysis.dateTaken' => ['nullable', 'string'],

            // copd
            'risk_assessment.copdAssessment'=> ['required', 'array'],
            'risk_assessment.copdAssessment.hasBreathlessness' => ['boolean'],
            'risk_assessment.copdAssessment.hasChronicCough'   => ['boolean'],
            'risk_assessment.copdAssessment.hasSputum'         => ['boolean'],
            'risk_assessment.copdAssessment.hasWheezing'       => ['boolean'],
        ];
    }
}
