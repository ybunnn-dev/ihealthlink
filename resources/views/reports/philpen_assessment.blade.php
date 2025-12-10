<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PhilPEN Risk Assessment Form</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 10px; 
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; vertical-align: top; }
        th { background-color: #eee; font-weight: bold; }
        .section-title { 
            background-color: #9fccfdff; 
            color: white; 
            text-align: center; 
            font-weight: bold; 
            padding: 5px; 
            margin-bottom: 5px; 
        }
        .checkbox { 
            display: inline-block; 
            width: 12px; 
            height: 12px; 
            border: 1px solid #000; 
            margin-right: 3px;
            text-align: center;
            line-height: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .label { font-weight: bold; }
        .value { /* Normal text */}
    </style>
</head>
<body>

    <div style="text-align: center; margin-bottom: 10px;">
        <h4>ANNEX C</h4>
        <h3>PHILPEN RISK ASSESSMENT FORM</h3>
        <p>Adults 20-59 years old</p>
    </div>

    @php
        // Helper function with solid dot - NO MORE QUESTION MARKS!
        function renderYesNo($value) {
            $yesCheck = ($value === 1 || $value === true) ? '●' : '';
            $noCheck = ($value === 0 || $value === false || $value === null) ? '●' : '';
            return "[ <span class='checkbox'>" . $yesCheck . "</span> Yes ] [ <span class='checkbox'>" . $noCheck . "</span> No ]";
        }

        // Extract data for easier access, providing defaults
        $resident = $consultation->enrolledResident->resident ?? null;
        $family = $resident->family ?? null;
        $household = $family->household ?? null;
        $purok = $household->purok ?? null;
        $barangay = $purok->barangay ?? null;

        $healthSigns = $consultation->healthSigns ?? (object)[];
        $medicalHistory = $consultation->medicalHistory ?? (object)[];
        $familyHistory = $consultation->familyHistory ?? (object)[];
        $ncd = $consultation->ncdRiskFactor ?? (object)[];
        $risk = $consultation->riskAssessment ?? (object)[];
        $mgmt = $consultation->philpenManagement ?? (object)[];

        // Format dates
        $birthdateFormatted = $resident && $resident->birthdate ? \Carbon\Carbon::parse($resident->birthdate)->format('m/d/Y') : '---';
        $assessmentDateFormatted = $consultation->created_at ? $consultation->created_at->format('m/d/Y') : '---';
        $followUpDateFormatted = $mgmt->follow_up_date ?? null ? \Carbon\Carbon::parse($mgmt->follow_up_date)->format('m/d/Y') : '---';

        // Age is passed from controller
        $ageDisplay = $age ?? '---';

        // Format Name
        $fullName = '---';
        if ($resident) {
            $fullName = strtoupper($resident->lastName . ', ' . $resident->firstName . ($resident->middleName ? ' ' . $resident->middleName : ''));
        }

        // Format Address
        $address = '---';
        if ($purok && $barangay) {
            $address = $purok->name . ', ' . $barangay->name;
        }

        // Calculate BMI if weight and height are available
        $bmi = '---';
        if (isset($ncd->weight) && isset($ncd->height) && $ncd->height > 0) {
            $heightInMeters = $ncd->height / 100;
            $bmi = number_format($ncd->weight / ($heightInMeters * $heightInMeters), 2);
        }

    @endphp

    <table>
        <tr>
            <td colspan="4"><span class="label">Name of Health Facility:</span> <span class="value">{{ $healthCenter }} Health Center</span></td>
            <td colspan="2"><span class="label">Date of Assessment:</span> <span class="value">{{ $assessmentDateFormatted }}</span></td>
        </tr>
    </table>

    <div class="section-title">I. PATIENT'S INFORMATION</div>
    <table>
        <tr>
            <td colspan="3"><span class="label">Patient Name:</span> <span class="value">{{ $fullName }}</span></td>
            <td><span class="label">Age:</span> <span class="value">{{ $ageDisplay }}</span></td>
            <td><span class="label">Sex:</span> <span class="value">{{ ucwords($resident->sex ?? '---') }}</span></td>
            <td><span class="label">Birthdate:</span> <span class="value">{{ $birthdateFormatted }}</span></td>
        </tr>
        <tr>
            <td><span class="label">PHIC No.:</span> <span class="value">{{ $resident->philhealth_no ?? '---' }}</span></td>
            <td><span class="label">Civil Status:</span> <span class="value">{{ ucwords($resident->civil_status ?? '---') }}</span></td>
            <td><span class="label">Religion:</span> <span class="value">{{ $resident->religion ?? '---' }}</span></td>
            <td colspan="3"><span class="label">Contact No.:</span> <span class="value">{{ $resident->contact_no ?? '---' }}</span></td>
        </tr>
        <tr>
            <td colspan="6"><span class="label">Patient's Address:</span> <span class="value">{{ $address }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="label">PWD ID Card No.:</span> <span class="value">{{ $resident->is_pwd ? ($resident->pwd_id ?? 'Yes, N/A') : 'No' }}</span></td>
            <td colspan="3"><span class="label">Employment Status:</span> <span class="value">{{ ucwords($resident->employment_status ?? '---') }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="label">Ethnicity:</span> <span class="value">{{ $resident->ethnicity ?? '---' }}</span></td>
            <td colspan="3">
                <span class="label">IP:</span> {!! renderYesNo($resident->is_indigenous ?? false) !!}
                <span class="label" style="margin-left: 15px;">Non-IP:</span> {!! renderYesNo(!($resident->is_indigenous ?? false)) !!}
            </td>
        </tr>
    </table>

    <div class="section-title">II. ASSESS FOR RED FLAGS</div>
    <table>
        <tr><td>2.1 Chest Pain</td> <td>{!! renderYesNo($healthSigns->chest_pain ?? null) !!}</td></tr>
        <tr><td>2.2 Difficulty of Breathing</td> <td>{!! renderYesNo($healthSigns->difficulty_in_breathing ?? null) !!}</td></tr>
        <tr><td>2.3 Loss of Consciousness</td> <td>{!! renderYesNo($healthSigns->loss_of_consciousness ?? null) !!}</td></tr>
        <tr><td>2.4 Slurred Speech</td> <td>{!! renderYesNo($healthSigns->slurred_speech ?? null) !!}</td></tr>
        <tr><td>2.5 Facial Asymmetry</td> <td>{!! renderYesNo($healthSigns->facial_asymmetry ?? null) !!}</td></tr>
        <tr><td>2.6 Weakness/Numbness on arm</td> <td>{!! renderYesNo($healthSigns->numbness_of_arm ?? null) !!}</td></tr>
        <tr><td>2.7 Disoriented as to time, place, person</td> <td>{!! renderYesNo($healthSigns->disoriented_as_to_time_place_or_person ?? null) !!}</td></tr>
        <tr><td>2.8 Chest Retractions</td> <td>{!! renderYesNo($healthSigns->chest_retractions ?? null) !!}</td></tr>
        <tr><td>2.9 Seizure or Convulsion</td> <td>{!! renderYesNo($healthSigns->seizure_or_convulsion ?? null) !!}</td></tr>
        <tr><td>2.10 Act of self-harm or suicide</td> <td>{!! renderYesNo($healthSigns->act_of_self_harm_or_suicide ?? null) !!}</td></tr>
        <tr><td>2.11 Agitated and/or aggressive behavior</td> <td>{!! renderYesNo($healthSigns->agitated_or_aggressive_behavior ?? null) !!}</td></tr>
        <tr><td>2.12 Eye Injury/Foreign Body on the eye</td> <td>{!! renderYesNo($healthSigns->eye_injury ?? null) !!}</td></tr>
        <tr><td>2.13 Severe Injuries</td> <td>{!! renderYesNo($healthSigns->severe_injuries ?? null) !!}</td></tr>
    </table>

    <div class="section-title">III. PAST MEDICAL HISTORY</div>
    <table>
        <tr><td>3.1 Hypertension</td> <td>{!! renderYesNo($medicalHistory->hypertension ?? null) !!}</td></tr>
        <tr><td>3.2 Heart Diseases</td> <td>{!! renderYesNo($medicalHistory->heart_diseases ?? null) !!}</td></tr>
        <tr><td>3.3 Diabetes</td> <td>{!! renderYesNo($medicalHistory->diabetes ?? null) !!}</td></tr>
        <tr><td>3.4 Cancer</td> <td>{!! renderYesNo($medicalHistory->cancer ?? null) !!}</td></tr>
        <tr><td>3.5 COPD</td> <td>{!! renderYesNo($medicalHistory->copd ?? null) !!}</td></tr>
        <tr><td>3.6 Asthma</td> <td>{!! renderYesNo($medicalHistory->asthma ?? null) !!}</td></tr>
        <tr><td>3.7 Allergies</td> <td>{!! renderYesNo($medicalHistory->allergies ?? null) !!}</td></tr>
        <tr><td>3.8 Mental, Neurological, Substance-Abuse Disorders</td> <td>{!! renderYesNo($medicalHistory->mental_neuro_substance_disorders ?? null) !!}</td></tr>
        <tr><td>3.9 Vision Problems</td> <td>{!! renderYesNo($medicalHistory->vision_problems ?? null) !!}</td></tr>
        <tr><td>3.10 Previous Surgical History</td> <td>{!! renderYesNo($medicalHistory->surgical_history ?? null) !!}</td></tr>
        <tr><td>3.11 Thyroid Disorders</td> <td>{!! renderYesNo($medicalHistory->thyroid_disorders ?? null) !!}</td></tr>
        <tr><td>3.12 Kidney Disorders</td> <td>{!! renderYesNo($medicalHistory->kidney_disorders ?? null) !!}</td></tr>
    </table>

    <div class="section-title">IV. FAMILY HISTORY</div>
    <table>
        <tr><td>4.1 Hypertension</td> <td>{!! renderYesNo($familyHistory->hypertension ?? null) !!}</td></tr>
        <tr><td>4.2 Stroke</td> <td>{!! renderYesNo($familyHistory->stroke ?? null) !!}</td></tr>
        <tr><td>4.3 Heart Disease</td> <td>{!! renderYesNo($familyHistory->heart_diseases ?? null) !!}</td></tr>
        <tr><td>4.4 Premature Coronary or Vascular Disease</td> <td>{!! renderYesNo($familyHistory->premature_coronary_or_vascular_disease ?? null) !!}</td></tr>
        <tr><td>4.5 Diabetes Mellitus</td> <td>{!! renderYesNo($familyHistory->diabetes_mellitus ?? null) !!}</td></tr>
        <tr><td>4.6 Cancer</td> <td>{!! renderYesNo($familyHistory->cancer ?? null) !!}</td></tr>
        <tr><td>4.7 Asthma</td> <td>{!! renderYesNo($familyHistory->asthma ?? null) !!}</td></tr>
        <tr><td>4.8 Mental, Neurological, Substance Abuse Disorders</td> <td>{!! renderYesNo($familyHistory->mental_neurological_substance_abuse_disorders ?? null) !!}</td></tr>
        <tr><td>4.9 Kidney Disorders</td> <td>{!! renderYesNo($familyHistory->kidney_disorders ?? null) !!}</td></tr>
        <tr><td>4.10 Tuberculosis (last 5 years)</td> <td>{!! renderYesNo($familyHistory->tuberculosis_last_five_years ?? null) !!}</td></tr>
        <tr><td>4.11 COPD</td> <td>{!! renderYesNo($familyHistory->copd ?? null) !!}</td></tr>
    </table>

    <div class="section-title">V. NCD RISK FACTORS</div>
    <table>
        <tr>
            <td colspan="2"><span class="label">5.1 Tobacco Use:</span> {{ ucwords($ncd->tobacco_use ?? '---') }}</td>
        </tr>
        <tr>
            <td><span class="label">5.2 Alcohol Intake:</span> {!! renderYesNo($ncd->alcohol_intake ?? null) !!}</td>
            <td><span class="label">Number of Drinks (last year):</span> {{ $ncd->number_of_drinks_last_year ?? '---' }}</td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">5.3 Physical Activity (hours/week):</span> {{ $ncd->hours_of_activity_weekly ?? '---' }}</td>
        </tr>
        <tr>
            <td><span class="label">5.4a Caffeine Intake:</span> {!! renderYesNo($ncd->caffeine_intake ?? null) !!}</td>
            <td><span class="label">5.4b Street Foods Intake:</span> {!! renderYesNo($ncd->street_foods_intake ?? null) !!}</td>
            
        </tr>
        <tr>
            <td><span class="label">5.5 Weight (kg):</span> {{ $ncd->weight ?? '---' }}</td>
            <td><span class="label">5.6 Height (cm):</span> {{ $ncd->height ?? '---' }}</td>
        </tr>
        <tr>
            <td><span class="label">5.7 Body Mass Index:</span> {{ $bmi }}</td>
            <td><span class="label">5.8 Waist Circumference (cm):</span> {{ $ncd->waist_circumference ?? '---' }}</td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">5.9 Blood Pressure (mmHg):</span> {{ $ncd->systolic_pressure ?? '---' }} / {{ $ncd->diastolic_pressure ?? '---' }}</td>
        </tr>
    </table>

    <div class="section-title">VI. RISK SCREENING</div>
    <table>
        <tr>
            <td rowspan="6" style="width: 30%;"><strong>6.1 Hypertension/Diabetes/Hypercholesterolemia/Renal Diseases</strong></td>
            <td><span class="label">FBS Result:</span> {{ $risk->fbs_result ?? '---' }} mg/dL</td>
            <td><span class="label">Date Taken:</span> {{ $risk->blood_sugar_date_taken ? \Carbon\Carbon::parse($risk->blood_sugar_date_taken)->format('m/d/Y') : '---' }}</td>
        </tr>
        <tr>
            <td><span class="label">RBS Result:</span> {{ $risk->rbs_result ?? '---' }} mg/dL</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>DM Clinical Symptoms:</strong><br>
                Polyphagia {!! renderYesNo($risk->polyphagia ?? null) !!} &nbsp;
                Polydipsia {!! renderYesNo($risk->polydipsia ?? null) !!} &nbsp;
                Polyuria {!! renderYesNo($risk->polyuria ?? null) !!}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span class="label">Lipid Profile:</span><br>
                Total Cholesterol: {{ $risk->total_cholesterol ?? '---' }} mg/dL<br>
                HDL: {{ $risk->hdl ?? '---' }} mg/dL<br>
                LDL: {{ $risk->ldl ?? '---' }} mg/dL<br>
                VLDL: {{ $risk->vldl ?? '---' }} mg/dL<br>
                Triglyceride: {{ $risk->triglyceride ?? '---' }} mg/dL
            </td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">Date Taken:</span> {{ $risk->lipid_profile_date_taken ? \Carbon\Carbon::parse($risk->lipid_profile_date_taken)->format('m/d/Y') : '---' }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <span class="label">Urinalysis:</span><br>
                Protein: {{ $risk->protein ?? '---' }}<br>
                Ketones: {{ $risk->ketones ?? '---' }}<br>
                Date Taken: {{ $risk->urinalysis_date_taken ? \Carbon\Carbon::parse($risk->urinalysis_date_taken)->format('m/d/Y') : '---' }}
            </td>
        </tr>
        <tr>
            <td rowspan="5" style="width: 30%;"><strong>6.2 Chronic Respiratory Diseases</strong></td>
            <td colspan="2">Breathlessness {!! renderYesNo($risk->breathlessness ?? null) !!}</td>
        </tr>
        <tr><td colspan="2">Chronic cough {!! renderYesNo($risk->chronic_cough ?? null) !!}</td></tr>
        <tr><td colspan="2">Sputum production {!! renderYesNo($risk->sputum_production ?? null) !!}</td></tr>
        <tr><td colspan="2">Chest tightness {!! renderYesNo(null) !!}</td></tr>
        <tr><td colspan="2">Wheezing {!! renderYesNo($risk->wheezing ?? null) !!}</td></tr>
    </table>

    <div class="section-title">VII. MANAGEMENT</div>
    <table>
        <tr><td style="width: 60%;">Lifestyle Modification</td> <td>{!! renderYesNo($mgmt->is_lifestyle_modification ?? null) !!}</td></tr>
        <tr><td colspan="2"><strong>Medications:</strong></td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp; a. Anti-Hypertensives</td> <td>{!! renderYesNo($mgmt->is_anti_hypertensive ?? null) !!}</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp; b. Oral Hypoglycemic Agents/Insulin</td> <td>{!! renderYesNo($mgmt->is_insulin ?? null) !!}</td></tr>
        <tr><td>Date of Follow-up:</td> <td>{{ $followUpDateFormatted }}</td></tr>
        <tr><td>Remarks:</td> <td>{{ $mgmt->remarks ?? '---' }}</td></tr>
    </table>

    <div style="margin-top: 20px;">
        <table>
            <tr>
                <td style="width: 50%;"><span class="label">Assessed by:</span> {{ $personnel->firstName ?? '' }} {{ $personnel->lastName ?? '' }}</td>
                <td><span class="label">Date:</span> {{ $assessmentDateFormatted }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
