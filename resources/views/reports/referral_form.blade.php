<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Referral Form</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 11px;
            margin: 25px;
        }
        .container {
            width: 100%;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .field-group {
            margin-bottom: 6px;
        }
        .field-label {
            display: inline-block;
        }
        .field-value {
            display: inline-block;
            border-bottom: 1px solid #000;
            padding: 0 5px;
            min-width: 150px;
            font-weight: bold;
            font-family: 'Courier New', Courier, monospace;
        }
        .full-width {
            width: 100%;
        }
        .half-width {
            width: 48%;
            display: inline-block;
        }
        .third-width {
            width: 32%;
            display: inline-block;
        }
        .quarter-width {
            width: 24%;
            display: inline-block;
        }
        .box-label {
            margin-right: 15px;
        }
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;
        }
        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .return-slip {
            border-top: 2px dashed #000;
            margin-top: 40px;
            padding-top: 15px;
        }
        .return-slip .header {
            font-size: 14px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            height: 1px;
            margin-top: 40px;
            margin-bottom: 5px;
        }
        .signature-label {
            text-align: center;
            font-size: 10px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">REFERRAL FORM</div>

        <div class="field-group">
            <div class="half-width">
                <span class="field-label">Referred to:</span>
                <span class="field-value">MUNICIPAL HEALTH OFFICE DARAGA, ALBAY</span>
            </div>
            <div class="half-width">
                <span class="field-label">Referred Date:</span>
                <span class="field-value" style="min-width: 100px;">{{ $data['referralInfo']['referredDate'] ? \Carbon\Carbon::parse($data['referralInfo']['referredDate'])->format('m/d/Y') : '' }}</span>
                <span class="field-label">Time:</span>
                <span class="field-value" style="min-width: 80px;">{{ $data['referralInfo']['referredTime'] ? \Carbon\Carbon::parse($data['referralInfo']['referredTime'])->format('h:i A') : '' }}</span>
            </div>
        </div>
        <div class="field-group">
            <span class="field-label">Referred from: {{ $data['referralInfo']['purok'] }}</span>
            <span class="field-value" style="width: 80%;">{{ $data['referralInfo']['referredFrom'] }}</span>
        </div>
        <div class="field-group">
            <span class="box-label">( {{ $data['referralInfo']['referralNeeds'] === 'checkup' ?  'X' : ''}}) Check-up</span>
            <span class="box-label">( {{ $data['referralInfo']['referralNeeds'] === 'dental' ?  'X' : ''}}) Dental</span>
            <span class="box-label">( {{ $data['referralInfo']['referralNeeds'] === 'meds' ?  'X' : ''}}) Maintenance Meds.</span>
            <span class="box-label">( {{ $data['referralInfo']['referralNeeds'] === 'lab' ?  'X' : ''}}) Laboratory</span>
            <span class="box-label">( {{ $data['referralInfo']['referralNeeds'] === 'hygiene' ?  'X' : ''}}) Total Hygiene Clinic</span>
            <span class="box-label">( {{ $data['referralInfo']['referralNeeds'] === 'others' ?  'X' : ''}}) Others</span>
        </div>

        <div class="field-group" style="margin-top: 20px;">
            <div class="full-width">
                <span class="field-label">NAME OF PATIENT:</span>
                <span class="field-value" style="width: 45%;">{{ $data['patientInfo']['name'] }}</span>
                <span class="field-label">BIRTHDAY:</span>
                <span class="field-value" style="min-width: 100px;">{{ $data['patientInfo']['birthdate'] ? \Carbon\Carbon::parse($data['patientInfo']['birthdate'])->format('m/d/Y') : '' }}</span>
                <span class="field-label">AGE/MONTHS:</span>
                <span class="field-value" style="min-width: 80px;">{{ $data['patientInfo']['age'] }}</span>
            </div>
        </div>
        <div class="field-group">
            <div class="full-width">
                <span class="field-label">ADDRESS: </span>
                <span class="field-value" style="width: 50%;">{{ $data['patientInfo']['address'] }}</span>
                <span class="field-label">SEX:</span>
                <span class="field-value" style="min-width: 80px;">{{ $data['patientInfo']['sex'] }}</span>
                <span class="field-label">CIVIL STATUS:</span>
                <span class="field-value" style="min-width: 100px;">{{ $data['patientInfo']['civilStatus'] }}</span>
            </div>
        </div>
        <div class="field-group">
             <div class="half-width">
                <span class="field-label">FATHER'S NAME:</span>
                <span class="field-value" style="width: 65%;">{{ $data['patientInfo']['fatherName'] }}</span>
            </div>
             <div class="half-width">
                <span class="field-label">MOTHER'S NAME:</span>
                <span class="field-value" style="width: 65%;">{{ $data['patientInfo']['motherName'] }}</span>
            </div>
        </div>

        <div class="field-group">
            <span class="field-label">HEIGHT:</span> <span class="field-value" style="min-width: 50px;">{{ $data['vitalSigns']['height'] }}</span> cm.
            <span class="field-label">WEIGHT:</span> <span class="field-value" style="min-width: 50px;">{{ $data['vitalSigns']['weight'] }}</span> kgs.
            <span class="field-label">TEMP:</span> <span class="field-value" style="min-width: 50px;">{{ $data['vitalSigns']['temperature'] }}</span> C
            <span class="field-label">BP:</span> <span class="field-value" style="min-width: 80px;">{{ $data['vitalSigns']['bloodPressure']['systolic'] }}/{{ $data['vitalSigns']['bloodPressure']['diastolic'] }}</span> mmHg
            <span class="field-label">PR:</span> <span class="field-value" style="min-width: 50px;">{{ $data['vitalSigns']['pulseRate'] }}</span> bpm.
            <span class="field-label">RR:</span> <span class="field-value" style="min-width: 50px;">{{ $data['vitalSigns']['respiratoryRate'] }}</span> rpm.
        </div>

        <div class="section-title">FOR FEMALE 18 Y/O AND ABOVE:</div>
        <div class="field-group">
            <span class="checkbox">{{ $data['femalePatientDetails']['isPregnant'] && $data['femalePatientDetails']['isPregnant'] === "yes" ? 'X' : '' }}</span><span class="box-label">Pregnant</span>
            <span class="checkbox">{{ $data['femalePatientDetails']['isPregnant'] && $data['femalePatientDetails']['isPregnant'] === "no"? 'X' : '' }}</span><span class="box-label">Non Pregnant</span>
            <span class="field-label">Family Planning Method:</span>
            <span class="field-value" style="min-width: 200px;">{{ $data['femalePatientDetails']['fpMethod'] }}</span>
        </div>
        <div class="field-group">
            <span class="field-label">LMP:</span> <span class="field-value">{{ $data['femalePatientDetails']['lmpDate'] }}</span>
            <span class="field-label">EDD:</span> <span class="field-value">{{ $data['femalePatientDetails']['eddDate'] }}</span>
        </div>
         <div class="field-group">
            <span class="field-label">G:</span> <span class="field-value" style="min-width: 50px;">{{ $data['femalePatientDetails']['gravida'] }}</span>
            <span class="field-label">P:</span> <span class="field-value" style="min-width: 50px;">{{ $data['femalePatientDetails']['para'] }}</span>
            <span class="field-label">AOG:</span> <span class="field-value">{{ $data['femalePatientDetails']['aog'] }}</span>
        </div>

        <div class="section-title">For Infants:</div>
        <div class="field-group">
             <span class="field-label">Birth Weight:</span>
             <span class="field-value">{{ $data['infantDetails']['birthWeight'] }}</span>
        </div>

        <div class="section-title">CHIEF COMPLAINT:</div>
        <div class="field-group">
            <div class="field-value" style="width: 98%; min-height: 30px;">{{ $data['medicalDetails']['chiefComplaint'] }}</div>
        </div>
        <div class="section-title">Medicine already taken by patient/given prior to consultation:</div>
        <div class="field-group">
            <div class="field-value" style="width: 98%; min-height: 30px;">{{ $data['medicalDetails']['medicineTaken'] }}</div>
        </div>
        <div class="section-title">Management done:</div>
        <div class="field-group">
            <div class="field-value" style="width: 98%; min-height: 30px;">{{ $data['medicalDetails']['managementDone'] }}</div>
        </div>

        <div class="signature-line" style="width: 40%; float: right;"></div>
        <div class="signature-label" style="width: 40%; float: right; clear: right;">(Sig. Over Printed Name of Health Services Provider)</div>

        <div class="return-slip" style="clear: both;">
            <div class="header">RETURN SLIP</div>
             <div class="field-group">
                <span class="field-label">From Receiving Facility:</span>
                <span class="field-value" style="width: 75%;"></span>
            </div>
            <div class="field-group">
                <div class="half-width">
                    <span class="field-label">Name of Patient:</span>
                    <span class="field-value" style="width: 70%;"></span>
                </div>
                <div class="half-width">
                    <span class="field-label">Received Date:</span>
                    <span class="field-value" style="min-width: 100px;"></span>
                    <span class="field-label">Time:</span>
                    <span class="field-value" style="min-width: 80px;"></span>
                </div>
            </div>
             <div class="field-group">
                <span class="field-label">Address; Purok:</span><span class="field-value" style="width: 40%;"></span>
                <span class="field-label">Age/Months:</span><span class="field-value" style="min-width: 80px;"></span>
                <span class="field-label">Sex:</span><span class="field-value" style="min-width: 80px;"></span>
            </div>
             <div class="field-group">
                <span class="field-label">Civil Status:</span><span class="field-value" style="width: 85%;"></span>
            </div>
             <div class="section-title">Final Diagnosis:</div>
             <div class="field-group">
                <div class="field-value" style="width: 98%; min-height: 50px;"></div>
            </div>
            <div class="signature-line" style="width: 40%; float: right;"></div>
            <div class="signature-label" style="width: 40%; float: right; clear: right;">Signature Over Printed Name of Receiving Staff</div>
        </div>

    </div>
</body>
</html>