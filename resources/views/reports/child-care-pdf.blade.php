<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Child Care Record</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 0; font-size: 14px; color: #555; }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            background-color: #f2f2f2;
            padding: 8px;
            margin-top: 20px;
            border-bottom: 2px solid #ddd;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .data-table .label {
            font-weight: bold;
            width: 35%;
            background-color: #fafafa;
        }
        .data-table .value { width: 65%; }
        .assessment-table { width: 100%; border-collapse: collapse; }
        .assessment-table td { border: 1px solid #ddd; padding: 5px; }
        .assessment-table th { border: 1px solid #ddd; padding: 5px; background-color: #fafafa; text-align: left;}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Child Immunization and Nutrition Services</h1>
            <p>Barangay Health Center Record</p>
        </div>

        {{-- Basic Information --}}
        <div class="section-title">Basic Information</div>
        <table class="data-table">
            <tr>
                <td class="label">Full Name of Child</td>
                <td class="value">{{ $record->basicInfo['fullName'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Date of Birth</td>
                <td class="value">{{ $record->basicInfo['birthDate'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Sex</td>
                <td class="value">{{ ucfirst($record->basicInfo['sex'] ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td class="label">Complete Name of Mother</td>
                <td class="value">{{ $record->basicInfo['motherFullName'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Complete Address</td>
                <td class="value">{{ $record->basicInfo['address'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Family #</td>
                <td class="value">{{ $record->basicInfo['familyNumber'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Social Economic Status</td>
                <td class="value">{{ strtoupper($record->basicInfo['ses'] ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td class="label">Date of Registration</td>
                <td class="value">{{ $record->basicInfo['registrationDate'] ?? 'N/A' }}</td>
            </tr>
        </table>

        {{-- At Birth --}}
        <div class="section-title">Newborn Details (At Birth)</div>
        <table class="data-table">
            <tr>
                <td class="label">Mother's Tetanus Status</td>
                <td class="value">{{ $record->atBirth['motherTetanusStatus'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Birth Weight</td>
                <td class="value">{{ $record->atBirth['birthWeightKg'] ?? 'N/A' }} kg</td>
            </tr>
            <tr>
                <td class="label">Birth Weight Status</td>
                <td class="value">{{ ucfirst($record->atBirth['birthWeightStatus'] ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td class="label">Initiated Breastfeeding</td>
                <td class="value">{{ $record->atBirth['initiatedBreastfeeding'] ?? 'N/A' }}</td>
            </tr>
        </table>

        {{-- ✅ NEW: Nutritional Assessments Section --}}
        <div class="section-title">Nutritional Assessments</div>
        <table class="assessment-table">
            <thead>
                <tr>
                    <th>Age Period</th>
                    <th>Weight (kg) / Date</th>
                    <th>Length/Height (cm) / Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>1-3 Months</strong></td>
                    <td>{{ $record->assessments['oneToThreeMonths']['weightKg'] ?? 'N/A' }} kg on {{ $record->assessments['oneToThreeMonths']['weightDate'] ?? 'N/A' }}</td>
                    <td>{{ $record->assessments['oneToThreeMonths']['lengthCm'] ?? 'N/A' }} cm on {{ $record->assessments['oneToThreeMonths']['lengthDate'] ?? 'N/A' }}</td>
                    <td>{{ $record->assessments['oneToThreeMonths']['status'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>6-11 Months</strong></td>
                    <td>{{ $record->assessments['sixToElevenMonths']['weightKg'] ?? 'N/A' }} kg on {{ $record->assessments['sixToElevenMonths']['weightDate'] ?? 'N/A' }}</td>
                    <td>{{ $record->assessments['sixToElevenMonths']['lengthCm'] ?? 'N/A' }} cm on {{ $record->assessments['sixToElevenMonths']['lengthDate'] ?? 'N/A' }}</td>
                    <td>{{ $record->assessments['sixToElevenMonths']['status'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>12 Months</strong></td>
                    <td>{{ $record->assessments['twelveMonths']['weightKg'] ?? 'N/A' }} kg on {{ $record->assessments['twelveMonths']['weightDate'] ?? 'N/A' }}</td>
                    <td>{{ $record->assessments['twelveMonths']['heightCm'] ?? 'N/A' }} cm on {{ $record->assessments['twelveMonths']['heightDate'] ?? 'N/A' }}</td>
                    <td>{{ $record->assessments['twelveMonths']['status'] ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Nutrition & Feeding --}}
        <div class="section-title">Nutrition & Feeding Status</div>
        <table class="data-table">
            <tr>
                <td class="label">Exclusive Breastfeeding (1.5 mo)</td>
                <td class="value">{{ ucfirst($record->nutrition['exclusiveBreastfeeding']['at1_5months']['status'] ?? 'N/A') }} - {{ $record->nutrition['exclusiveBreastfeeding']['at1_5months']['date'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Exclusive Breastfeeding (2.5 mos)</td>
                <td class="value">{{ ucfirst($record->nutrition['exclusiveBreastfeeding']['at2_5months']['status'] ?? 'N/A') }} - {{ $record->nutrition['exclusiveBreastfeeding']['at2_5months']['date'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Exclusive Breastfeeding (3.5 mos)</td>
                <td class="value">{{ ucfirst($record->nutrition['exclusiveBreastfeeding']['at3_5months']['status'] ?? 'N/A') }} - {{ $record->nutrition['exclusiveBreastfeeding']['at3_5months']['date'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Exclusive Breastfeeding (4-5 mos)</td>
                <td class="value">{{ ucfirst($record->nutrition['exclusiveBreastfeeding']['at4_5months']['status'] ?? 'N/A') }} - {{ $record->nutrition['exclusiveBreastfeeding']['at4_5months']['date'] ?? '' }}</td>
            </tr>
            <tr>
                {{-- ✅ UPDATED: Label changed here --}}
                <td class="label">Exclusive Breastfeeding at 6 months</td>
                <td class="value">{{ ucfirst($record->nutrition['exclusiveBreastfeeding']['statusAt6Months'] ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td class="label">Date Stopped Breastfeeding</td>
                <td class="value">{{ $record->nutrition['exclusiveBreastfeeding']['dateStopped'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Complementary Feeding Started</td>
                <td class="value">{{ $record->nutrition['complementaryFeedingStarted'] ?? 'N/A' }}</td>
            </tr>
        </table>

        {{-- Immunizations --}}
        <div class="section-title">Immunization Record</div>
        <table class="data-table">
            <tr><td class="label">BCG</td><td class="value">{{ $record->immunizations['bcgDate'] ?? 'N/A' }}</td></tr>
            <tr><td class="label">Hepa B (Birth Dose)</td><td class="value">{{ $record->immunizations['hepaBDate'] ?? 'N/A' }}</td></tr>
            <tr>
                <td class="label">DPT-HiB-HepB</td>
                <td class="value">
                    Dose 1: {{ $record->immunizations['dptHibHepb']['dose1'] ?? 'N/A' }} <br>
                    Dose 2: {{ $record->immunizations['dptHibHepb']['dose2'] ?? 'N/A' }} <br>
                    Dose 3: {{ $record->immunizations['dptHibHepb']['dose3'] ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="label">OPV</td>
                <td class="value">
                    Dose 1: {{ $record->immunizations['opv']['dose1'] ?? 'N/A' }} <br>
                    Dose 2: {{ $record->immunizations['opv']['dose2'] ?? 'N/A' }} <br>
                    Dose 3: {{ $record->immunizations['opv']['dose3'] ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="label">PCV</td>
                <td class="value">
                    Dose 1: {{ $record->immunizations['pcv']['dose1'] ?? 'N/A' }} <br>
                    Dose 2: {{ $record->immunizations['pcv']['dose2'] ?? 'N/A' }} <br>
                    Dose 3: {{ $record->immunizations['pcv']['dose3'] ?? 'N/A' }}
                </td>
            </tr>
            <tr><td class="label">IPV</td><td class="value">{{ $record->immunizations['ipvDate'] ?? 'N/A' }}</td></tr>
            <tr><td class="label">MMR Dose 1</td><td class="value">{{ $record->immunizations['mmr1Date'] ?? 'N/A' }}</td></tr>
            <tr><td class="label">MMR Dose 2</td><td class="value">{{ $record->immunizations['mmr2Date'] ?? 'N/A' }}</td></tr>
            <tr><td class="label">FIC Date</td><td class="value">{{ $record->immunizations['ficDate'] ?? 'N/A' }}</td></tr>
            <tr><td class="label">CIC Date</td><td class="value">{{ $record->immunizations['cicDate'] ?? 'N/A' }}</td></tr>
        </table>

        {{-- Remarks --}}
        <div class="section-title">Remarks</div>
        <p style="padding: 10px; border: 1px solid #ddd;">{{ $record->remarks ?? 'No remarks.' }}</p>

    </div>
</body>
</html>