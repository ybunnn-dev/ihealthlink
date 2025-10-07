<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Maternal Health Record</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 18px;
            color: #279EFF;
            font-weight: bold;
        }
        h2 {
            font-size: 14px;
            background-color: #DFEEFF;
            padding: 8px;
            margin-top: 25px;
            border-left: 4px solid #279EFF;
            color: #279EFF;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #DFEEFF;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #DFEEFF;
            font-weight: bold;
            width: 35%;
            color: #279EFF;
        }
        .value {
            width: 65%;
            background-color: white;
        }
        .full-width-table th, .full-width-table td {
            width: auto;
        }
        .full-width-table td {
            background-color: white;
        }
        .sub-table {
            margin: 10px 0;
        }
        .sub-table th {
            width: 25%;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Maternal Health Record</h1>

        <h2>General Information</h2>
        <table>
            <tr>
                <th>Date of Registration</th>
                <td class="value">{{ $data['generalInfo']['dateOfRegistration'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Resident Name</th>
                <td class="value">{{ $data['generalInfo']['residentName'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Family Number</th>
                <td class="value">{{ $data['generalInfo']['familyNumber'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td class="value">{{ $data['generalInfo']['address'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Social Economic Status (Indigent)</th>
                <td class="value">{{ isset($data['generalInfo']['isIndigent']) ? ($data['generalInfo']['isIndigent'] ? 'Yes' : 'No') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Age</th>
                <td class="value">{{ $data['generalInfo']['age'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Gravida/Para</th>
                <td class="value">G{{ $data['generalInfo']['gravida'] ?? '?' }}P{{ $data['generalInfo']['para'] ?? '?' }}</td>
            </tr>
            <tr>
                <th>Last Menstrual Period (LMP)</th>
                <td class="value">{{ $data['generalInfo']['lmp'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Expected Date of Confinement (EDC)</th>
                <td class="value">{{ $data['generalInfo']['edc'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h2>Prenatal Checkups</h2>
        <table>
            <tr>
                <th>1st Trimester</th>
                <td class="value">{{ $data['prenatalCheckups']['firstTrimester'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>2nd Trimester</th>
                <td class="value">{{ $data['prenatalCheckups']['secondTrimester'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>3rd Trimester (1st Visit)</th>
                <td class="value">{{ $data['prenatalCheckups']['thirdTrimesterFirst'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>3rd Trimester (2nd Visit)</th>
                <td class="value">{{ $data['prenatalCheckups']['thirdTrimesterSecond'] ?? 'N/A' }}</td>
            </tr>
        </table>
        
        <h2>Tetanus Diphtheria (Td) Immunization</h2>
        <table class="full-width-table">
            <thead>
                <tr>
                    <th>TD1</th>
                    <th>TD2</th>
                    <th>TD3</th>
                    <th>TD4</th>
                    <th>TD5</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data['immunization']['tetanusDiphtheria']['td1'] ?? 'N/A' }}</td>
                    <td>{{ $data['immunization']['tetanusDiphtheria']['td2'] ?? 'N/A' }}</td>
                    <td>{{ $data['immunization']['tetanusDiphtheria']['td3'] ?? 'N/A' }}</td>
                    <td>{{ $data['immunization']['tetanusDiphtheria']['td4'] ?? 'N/A' }}</td>
                    <td>{{ $data['immunization']['tetanusDiphtheria']['td5'] ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <h2>Micronutrient Supplementation</h2>
        
        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Iron Sulfate</h3>
        <table class="full-width-table sub-table">
            <thead>
                <tr>
                    <th>Checkup</th>
                    <th>Checkup 1</th>
                    <th>Checkup 2</th>
                    <th>Checkup 3</th>
                    <th>Checkup 4</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Amount</th>
                    <td>{{ $data['micronutrientSupplementation']['ironSulfate']['checkup1']['amount'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['ironSulfate']['checkup2']['amount'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['ironSulfate']['checkup3']['amount'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['ironSulfate']['checkup4']['amount'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $data['micronutrientSupplementation']['ironSulfate']['checkup1']['date'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['ironSulfate']['checkup2']['date'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['ironSulfate']['checkup3']['date'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['ironSulfate']['checkup4']['date'] ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Calcium Carbonate</h3>
        <table class="full-width-table sub-table">
            <thead>
                <tr>
                    <th>Checkup</th>
                    <th>Checkup 2</th>
                    <th>Checkup 3</th>
                    <th>Checkup 4</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Amount</th>
                    <td>{{ $data['micronutrientSupplementation']['calciumCarbonate']['checkup2']['amount'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['calciumCarbonate']['checkup3']['amount'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['calciumCarbonate']['checkup4']['amount'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $data['micronutrientSupplementation']['calciumCarbonate']['checkup2']['date'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['calciumCarbonate']['checkup3']['date'] ?? 'N/A' }}</td>
                    <td>{{ $data['micronutrientSupplementation']['calciumCarbonate']['checkup4']['date'] ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Iodine Capsule</h3>
        <table>
            <tr>
                <th>Amount (Checkup 1)</th>
                <td class="value">{{ $data['micronutrientSupplementation']['iodineCapsule']['checkup1']['amount'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Date (Checkup 1)</th>
                <td class="value">{{ $data['micronutrientSupplementation']['iodineCapsule']['checkup1']['date'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h2>Health Status</h2>
        <table>
            <tr>
                <th>FIM Status</th>
                <td class="value">{{ $data['healthStatus']['fimStatus'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Deworming Date</th>
                <td class="value">{{ $data['healthStatus']['dewormingDate'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>BMI</th>
                <td class="value">{{ $data['healthStatus']['bmi'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h2>Laboratory and Disease Screening</h2>
        
        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Infectious Disease</h3>
        <table>
            <tr>
                <th>Syphilis - Date</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['infectiousDisease']['syphilis']['date'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Syphilis - Result</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['infectiousDisease']['syphilis']['result'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Hepatitis B - Date</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['infectiousDisease']['hepatitisB']['date'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Hepatitis B - Result</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['infectiousDisease']['hepatitisB']['result'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>HIV - Date</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['infectiousDisease']['hiv']['date'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>HIV - Result</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['infectiousDisease']['hiv']['result'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Laboratory Tests</h3>
        <table>
            <tr>
                <th>Gestational Diabetes - Date</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['laboratory']['gestationalDiabetes']['date'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Gestational Diabetes - Result</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['laboratory']['gestationalDiabetes']['result'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>CBC - Date</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['laboratory']['cbc']['date'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>CBC - Result</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['laboratory']['cbc']['result'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>CBC - Given Iron</th>
                <td class="value">{{ $data['labAndDiseaseScreening']['laboratory']['cbc']['givenIron'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h2>Pregnancy Outcome</h2>
        <table>
            <tr>
                <th>Date Terminated</th>
                <td class="value">{{ $data['pregnancyOutcome']['dateTerminated'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Outcome</th>
                <td class="value">{{ $data['pregnancyOutcome']['outcome'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Sex</th>
                <td class="value">{{ $data['pregnancyOutcome']['sex'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Type of Delivery</th>
                <td class="value">{{ $data['pregnancyOutcome']['typeOfDelivery'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Birth Weight (kg)</th>
                <td class="value">{{ $data['pregnancyOutcome']['birthWeightKg'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h2>Delivery Information</h2>
        
        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Place of Delivery</h3>
        <table>
            <tr>
                <th>Health Facility Type</th>
                <td class="value">{{ $data['deliveryInfo']['place']['healthFacilityType'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>BEmONC/CEmONC Capable</th>
                <td class="value">{{ $data['deliveryInfo']['place']['isBemmoncCemoncCapable'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Facility Ownership</th>
                <td class="value">{{ $data['deliveryInfo']['place']['facilityOwnership'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Birth Attendant</th>
                <td class="value">{{ $data['deliveryInfo']['place']['birthAttendant'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Remarks</th>
                <td class="value">{{ $data['deliveryInfo']['place']['remarks'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Date and Time of Delivery</h3>
        <table>
            <tr>
                <th>Date</th>
                <td class="value">{{ $data['deliveryInfo']['dateTime']['date'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Time</th>
                <td class="value">{{ $data['deliveryInfo']['dateTime']['time'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h2>Postpartum Care</h2>
        
        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Checkups</h3>
        <table>
            <tr>
                <th>Within 24 Hours</th>
                <td class="value">{{ $data['postpartumCare']['checkups']['within24Hours'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Within 7 Days</th>
                <td class="value">{{ $data['postpartumCare']['checkups']['within7Days'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Iron Supplementation</h3>
        <table class="full-width-table sub-table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Month 1</th>
                    <th>Month 2</th>
                    <th>Month 3</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Amount</th>
                    <td>{{ $data['postpartumCare']['supplementation']['iron']['month1']['amount'] ?? 'N/A' }}</td>
                    <td>{{ $data['postpartumCare']['supplementation']['iron']['month2']['amount'] ?? 'N/A' }}</td>
                    <td>{{ $data['postpartumCare']['supplementation']['iron']['month3']['amount'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $data['postpartumCare']['supplementation']['iron']['month1']['date'] ?? 'N/A' }}</td>
                    <td>{{ $data['postpartumCare']['supplementation']['iron']['month2']['date'] ?? 'N/A' }}</td>
                    <td>{{ $data['postpartumCare']['supplementation']['iron']['month3']['date'] ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <h3 style="font-size: 12px; color: #279EFF; margin: 15px 0 10px 0;">Vitamin A Supplementation</h3>
        <table>
            <tr>
                <th>Amount</th>
                <td class="value">{{ $data['postpartumCare']['supplementation']['vitaminA']['amount'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td class="value">{{ $data['postpartumCare']['supplementation']['vitaminA']['date'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <h2>General Remarks</h2>
        <table>
            <tr>
                <td class="value" style="padding: 15px;">{{ $data['remarks']['general'] ?? 'N/A' }}</td>
            </tr>
        </table>

    </div>
</body>
</html>