<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Tagas - Complete Report 2025</title>
    <style>
        /* --- General Styles --- */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }
        hr {
            border: 0;
            height: 1px;
            background: #ccc;
            margin: 20px 0;
        }
        .page-break {
            page-break-after: always;
        }

        /* --- Header Styles (Shared) --- */
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
            color: #279EFF; /* CHANGED */
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
        }

        /* --- Page 1: Profile Report Styles --- */
        .p1-body { font-size: 11px; }
        .main-layout {
            width: 100%;
            border-collapse: collapse;
        }
        .main-layout td {
            vertical-align: top;
            padding: 0 10px;
        }
        .column-left { width: 40%; }
        .column-right { width: 60%; }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
            padding-bottom: 3px;
            border-bottom: 2px solid #279EFF; /* CHANGED */
            color: #279EFF; /* ADDED */
        }
        .section-title:first-child { margin-top: 0; }
        .data-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .data-list li {
            padding: 2px 0;
            display: flex;
            justify-content: space-between;
        }
        .data-list .sub-item { padding-left: 20px; }
        .p1-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .p1-table th, .p1-table td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            text-align: left;
        }
        .p1-table th {
            background-color: #DFEEFF; /* CHANGED */
            font-weight: bold;
        }
        .p1-table td:nth-child(2), .p1-table td:nth-child(3) { text-align: center; }
        .total-row {
            font-weight: bold;
            background-color: #DFEEFF; /* CHANGED */
        }

        /* --- Page 2: Demographic Data Styles --- */
        .p2-table {
            width: 100%;
            border-collapse: collapse;
        }
        .p2-table th, .p2-table td {
            border: 1px solid #333;
            padding: 3px;
            text-align: center;
        }
        .p2-table th {
            background-color: #DFEEFF; /* CHANGED */
            font-weight: bold;
        }
        .p2-table td:first-child {
            text-align: left;
            font-weight: normal;
        }
        .section-header td {
            background-color: #279EFF; /* CHANGED */
            color: #FFFFFF; /* ADDED for contrast */
            font-weight: bold;
            text-align: center !important;
        }
        .category-row td {
            background-color: #DFEEFF; /* CHANGED */
            font-weight: bold;
        }
        .p2-table .sub-item td:first-child { padding-left: 15px; }
        .total-column {
            font-weight: bold;
            background-color: #DFEEFF; /* CHANGED */
        }
        .projection {
            font-weight: bold;
            font-size: 11px;
            margin-top: 15px;
        }
        .signatures {
            margin-top: 40px;
            width: 100%;
        }
        .signatures td {
            width: 33%;
            padding: 10px 0;
            vertical-align: top;
        }
        .signatures .name {
            font-weight: bold;
            margin-top: 40px;
            display: block;
        }
        .signatures .title { font-style: italic; }

        /* --- Page 3: Demographic Data by Age Styles --- */
        .p3-table {
            width: auto;
            min-width: 50%;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            font-family: sans-serif;
        }
        .p3-table th, .p3-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        .p3-table th:first-child, .p3-table td:first-child {
            width: 80px;
            text-align: left;
        }
        .p3-table th {
            font-weight: bold;
            background-color: #DFEEFF; /* CHANGED */
        }
        /* Targets the final 'Total' column and specific total rows on page 3 */
        .p3-table .total-column,
        .p3-table .category-row td {
            font-weight: bold;
            background-color: #DFEEFF; /* ADDED */
        }
    </style>
</head>
<body>
    <div class="p1-body">
        <div class="header">
            <h1>Barangay {{ $data['barangay_name'] ?? 'Tagas' }} - Community Profile Report {{ now()->year }}</h1>
            <h2>Coverage: Purok 1-10</h2>
        </div>
        <hr>
        <table class="main-layout">
            <tr>
                <td class="column-left">
                    <div class="section-title">Population Summary</div>
                    <ul class="data-list">
                        <li><span><strong>Total Population:</strong></span> <span>{{ $data['page1']['population']['total'] }}</span></li>
                        <li><span><strong>Total Households:</strong></span> <span>{{ $data['page1']['households']['total'] }}</span></li>
                        <li><span><strong>Total Families:</strong></span> <span>{{ $data['page1']['families'] }}</span></li>
                        <li><span><strong>Male:</strong></span> <span>{{ $data['page1']['population']['male'] }}</span></li>
                        <li><span><strong>Female:</strong></span> <span>{{ $data['page1']['population']['female'] }}</span></li>
                    </ul>

                    <div class="section-title">Vulnerable Sectors</div>
                    <ul class="data-list">
                        <li><span><strong>Senior Citizens:</strong></span> <span>{{ $data['page1']['seniors']['total'] ?? ($data['page1']['seniors'] ?? '___') }}</span></li>
                        <li class="sub-item"><span>Male:</span> <span>{{ $data['page1']['seniors']['male'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Female:</span> <span>{{ $data['page1']['seniors']['female'] ?? '___' }}</span></li>
                        <li><span><strong>Persons w/ Disabilities (PWD):</strong></span> <span>{{ $data['page1']['pwd']['total'] }}</span></li>
                        <li class="sub-item"><span>Male:</span> <span>{{ $data['page1']['pwd']['male'] }}</span></li>
                        <li class="sub-item"><span>Female:</span> <span>{{ $data['page1']['pwd']['female'] }}</span></li>
                    </ul>


                    <div class="section-title">Economic Profile</div>
                    <ul class="data-list">
                        <li><span><strong>Indigent Households:</strong></span> <span>{{ $data['page1']['households']['indigent'] }}</span></li>
                        <li><span><strong>Non-Indigent Households:</strong></span> <span>{{ $data['page1']['households']['non_indigent'] }}</span></li>
                        <li><span><strong>Enrolled in 4Ps:</strong></span> <span>{{ $data['page1']['four_ps'] }}</span></li>
                    </ul>

                    <div class="section-title">Maternal Health</div>
                    <ul class="data-list">
                        <li><span><strong>Women of Repro. Age (15-49):</strong></span> <span>{{ $data['page1']['wra'] }}</span></li>
                        <li><span><strong>Pregnant Women:</strong></span> <span>{{ $data['page1']['pregnant']['total'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Teen Pregnancies:</span> <span>{{ $data['page1']['pregnant']['teen'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Primigravida:</span> <span>{{ $data['page1']['pregnant']['primis'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Multipara:</span> <span>{{ $data['page1']['pregnant']['multiPara'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Others:</span> <span>{{ $data['page1']['pregnant']['others'] ?? '___' }}</span></li>
                        <li><span><strong>Lactating Mothers:</strong></span> <span>{{ $data['page1']['lactating'] ?? '___' }}</span></li>
                    </ul>

                    <div class="section-title">Family Planning</div>
                    <ul class="data-list">
                        <li><span><strong>Total Enrollees:</strong></span> <span>{{ $data['page1']['family_planning']['total'] ?? '___' }}</span></li>
                        @if(isset($data['page1']['family_planning']['methods']))
                            @foreach($data['page1']['family_planning']['methods'] as $method => $count)
                                <li class="sub-item"><span>{{ $method }}:</span> <span>{{ $count }}</span></li>
                            @endforeach
                        @endif
                    </ul>

                    <div class="section-title">Child Health Program</div>
                    <ul class="data-list">
                        <li><span><strong>Total Children Enrolled:</strong></span> <span>{{ $data['page1']['child_health']['total_enrolled'] }}</span></li>
                        <li><span><strong>Fully Immunized (FIC):</strong></span> <span>{{ $data['page1']['child_health']['fic'] }}</span></li>
                        <li><span><strong>Completely Immunized (CIC):</strong></span> <span>{{ $data['page1']['child_health']['cic'] }}</span></li>
                        <li><span><strong>With Weight & Height Records:</strong></span> <span>{{ $data['page1']['child_health']['with_weight_height'] }}</span></li>
                    </ul>
                </td>
                
                <td class="column-right">
                    <div class="section-title">Age & Sex Distribution</div>
                    <table class="p1-table">
                        <thead>
                            <tr>
                                <th>Age Group</th>
                                <th>Male</th>
                                <th>Female</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['page1']['age_sex_distribution'] as $row)
                            <tr>
                                <td>{{ $row['group'] }}</td>
                                <td>{{ $row['male'] }}</td>
                                <td>{{ $row['female'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td>TOTAL</td>
                                <td>{{ $data['page1']['population']['male'] }}</td>
                                <td>{{ $data['page1']['population']['female'] }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="section-title">Child Nutritional Status</div>
                    <table class="p1-table">
                        <tr>
                            <td>Normal Weight</td>
                            <td style="width: 25%;">{{ $data['page1']['child_health']['nutrition']['normal'] }}</td>
                        </tr>
                        <tr>
                            <td>Underweight</td>
                            <td>{{ $data['page1']['child_health']['nutrition']['underweight'] }}</td>
                        </tr>
                        <tr>
                            <td>Severely Underweight</td>
                            <td>{{ $data['page1']['child_health']['nutrition']['severely_underweight'] }}</td>
                        </tr>
                        <tr>
                            <td>Overweight</td>
                            <td>{{ $data['page1']['child_health']['nutrition']['overweight'] }}</td>
                        </tr>
                        <tr>
                            <td>Obese</td>
                            <td>{{ $data['page1']['child_health']['nutrition']['obese'] }}</td>
                        </tr>
                    </table>

                    <div class="section-title">Household Sanitation</div>
                    <table class="p1-table">
                        <tr>
                            <td>With Sanitary Toilets</td>
                            <td style="width: 25%;">{{ $data['page1']['sanitation']['with_sanitary'] }}</td>
                        </tr>
                        <tr>
                            <td>With Unsanitary Toilets</td>
                            <td>{{ $data['page1']['sanitation']['with_unsanitary'] }}</td>
                        </tr>
                        <tr>
                            <td>Without Toilets</td>
                            <td>{{ $data['page1']['sanitation']['without'] }}</td>
                        </tr>
                    </table>

                    <div class="section-title">Household Water Source</div>
                    <table class="p1-table">
                        <tr>
                            <td>Pumpwell</td>
                            <td style="width: 25%;">{{ $data['page1']['water']['pumpwell'] }}</td>
                        </tr>
                        <tr>
                            <td>Open Well</td>
                            <td>{{ $data['page1']['water']['open_well'] }}</td>
                        </tr>
                        <tr>
                            <td>Purified Water</td>
                            <td>{{ $data['page1']['water']['purified'] }}</td>
                        </tr>
                        <tr>
                            <td>Tap Water</td>
                            <td>{{ $data['page1']['water']['tap'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="p2-body">
        <div class="header">
            <h1>DEMOGRAPHIC DATA BY AGE GROUP</h1>
            <h2>YEAR 2025</h2>
        </div>
        <table class="p2-table">
           <thead>
                <tr>
                    <th>Barangay TAGAS</th>
                    @foreach($data['puroks'] as $purokName)
                        <th>{{ $purokName }}</th>
                    @endforeach
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['page2']['summary'] as $item)
                <tr class="category-row">
                    <td>{{ $item['label'] }}</td>
                    @foreach($item['purok_data'] as $value)
                    <td>{{ $value }}</td>
                    @endforeach
                    <td class="total-column">{{ $item['total'] }}</td>
                </tr>
                @endforeach
                <tr class="section-header">
                    <td colspan="12">AGE GROUPING</td>
                </tr>
                @foreach($data['page2']['age_grouping'] as $group)
                    @if(isset($group['is_header']) && $group['is_header'])
                        <tr class="category-row">
                            <td colspan="12" style="text-align:left !important;">{{ $group['label'] }}</td>
                        </tr>
                    @else
                        <tr class="sub-item">
                            <td>{{ $group['label'] }}</td>
                            @foreach($group['purok_data'] as $value)
                            <td>{{ $value }}</td>
                            @endforeach
                            <td class="total-column">{{ $group['total'] }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="projection">
            Projected Population 2025: {{ $data['page2']['projected_population'] }}
        </div>
        <table class="signatures">
             <tr>
                <td>Consolidated By:</td>
                <td></td>
                <td>Date Consolidated:</td>
            </tr>
            <tr>
                <td>
                    <span class="name">_________________________</span>
                    <span class="title">Barangay Health Aide</span>
                </td>
                <td></td>
                <td>
                    <span class="name">_________________________</span>
                    <span class="title">Date</span>
                </td>
            </tr>
            <tr>
                <td>Noted By:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <span class="name">_________________________</span>
                    <span class="title">DOH NDP / Nurse</span>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="page-break"></div>
    <div class="p3-body">
        <div class="header">
            <h1>DEMOGRAPHIC DATA BY AGE</h1>
            <h2>YEAR 2025</h2>
        </div>

        <table class="p3-table">
            <thead>
                <tr>
                    <th>Age</th>
                    @foreach($data['page3']['puroks'] as $purokName)
                        <th>{{ $purokName }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $purokTotals = array_fill_keys($data['page3']['puroks'], 0);
                    $grandTotal = 0;
                    $maleGrandTotal = 0;
                    $femaleGrandTotal = 0;
                @endphp
                @foreach($data['page3']['ages'] as $age)
                    <tr class="age-row">
                        <td>{{ $age }}</td>

                        @php $rowTotal = 0; @endphp

                        @foreach($data['page3']['puroks'] as $purokName)
                            @php
                                $maleCount = $data['page3']['malePerPurok'][$purokName][$age] ?? 0;
                                $femaleCount = $data['page3']['femalePerPurok'][$purokName][$age] ?? 0;
                                $totalCount = $maleCount + $femaleCount;

                                // Accumulate totals
                                $rowTotal += $totalCount;
                                $purokTotals[$purokName] += $totalCount;
                                $maleGrandTotal += $maleCount;
                                $femaleGrandTotal += $femaleCount;
                            @endphp
                            <td>{{ $totalCount }}</td>
                        @endforeach

                        <td class="total-column">{{ $rowTotal }}</td>
                        @php $grandTotal += $rowTotal; @endphp
                    </tr>
                @endforeach

                <tr class="category-row">
                    <td><strong>TOTAL POPULATION</strong></td>
                    @foreach($data['page3']['puroks'] as $purokName)
                        <td><strong>{{ $purokTotals[$purokName] }}</strong></td>
                    @endforeach
                    <td class="total-column"><strong>{{ $grandTotal }}</strong></td>
                </tr>
                <tr class="category-row">
                    <td><strong>Male Total</strong></td>
                    <td colspan="{{ count($data['page3']['puroks']) }}" style="text-align: right;"></td>
                    <td class="total-column"><strong>{{ $maleGrandTotal }}</strong></td>
                </tr>
                <tr class="category-row">
                    <td><strong>Female Total</strong></td>
                    <td colspan="{{ count($data['page3']['puroks']) }}" style="text-align: right;"></td>
                    <td class="total-column"><strong>{{ $femaleGrandTotal }}</strong></td>
                </tr>
            </tbody>
        </table>

        <table class="signatures">
             <tr>
                <td>Consolidated By:</td>
                <td></td>
                <td>Date Consolidated:</td>
            </tr>
            <tr>
                <td>
                    <span class="name">_________________________</span>
                    <span class="title">Barangay Health Aide</span>
                </td>
                <td></td>
                <td>
                    <span class="name">_________________________</span>
                    <span class="title">Date</span>
                </td>
            </tr>
            <tr>
                <td>Noted By:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <span class="name">_________________________</span>
                    <span class="title">DOH NDP / Nurse</span>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

</body>
</html>