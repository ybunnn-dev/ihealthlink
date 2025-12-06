<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daraga Municipal Health Office - Community Report 2025</title>
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
            color: #279EFF;
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
            border-bottom: 2px solid #279EFF;
            color: #279EFF;
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
        .page-break {
            page-break-after: always;
        }
        /* Optional: Center headers for better look */
        .section-header td {
            text-align: center;
            background-color: #e0f2fe; /* light blue match */
            font-weight: bold;
        }
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
            background-color: #DFEEFF;
            font-weight: bold;
        }
        .p1-table td:nth-child(2), .p1-table td:nth-child(3) { text-align: center; }
        .total-row {
            font-weight: bold;
            background-color: #DFEEFF;
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
            background-color: #DFEEFF;
            font-weight: bold;
        }
        .p2-table td:first-child {
            text-align: left;
            font-weight: normal;
        }
        .section-header td {
            background-color: #279EFF;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center !important;
        }
        .category-row td {
            background-color: #DFEEFF;
            font-weight: bold;
        }
        .p2-table .sub-item td:first-child { padding-left: 15px; }
        .total-column {
            font-weight: bold;
            background-color: #DFEEFF;
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
            background-color: #DFEEFF;
        }
        .p3-table .total-column,
        .p3-table .category-row td {
            font-weight: bold;
            background-color: #DFEEFF;
        }
    </style>
</head>
<body>
    <div class="p1-body">
        <div class="header">
            <h1>Municipal Health Office - Community Profile Report</h1>
            <h2>Municipality-Wide Coverage</h2>
            @if($data['startDate'] || $data['endDate'])
            <h2>Period: {{ $data['startDate'] ?? 'N/A' }} - {{ $data['endDate'] ?? 'N/A' }}</h2>
            @endif
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
                        <li><span><strong>Senior Citizens:</strong></span> <span>{{ $data['page1']['seniors']['total'] }}</span></li>
                        <li class="sub-item"><span>Male:</span> <span>{{ $data['page1']['seniors']['male'] }}</span></li>
                        <li class="sub-item"><span>Female:</span> <span>{{ $data['page1']['seniors']['female'] }}</span></li>
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
                        <li><span><strong>Pregnant:</strong></span> <span>{{ $data['page1']['pregnant']['total'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Teen Pregnancies:</span> <span>{{ $data['page1']['pregnant']['teen'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Primis:</span> <span>{{ $data['page1']['pregnant']['primis'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>MultiPara:</span> <span>{{ $data['page1']['pregnant']['multiPara'] ?? '___' }}</span></li>
                        <li><span><strong>Lactating:</strong></span> <span>{{ $data['page1']['lactating'] ?? '___' }}</span></li>
                    </ul>

                    <div class="section-title">Family Planning</div>
                    <ul class="data-list">
                        <li><span><strong>Total Enrollees:</strong></span> <span>{{ $data['page1']['family_planning']['total'] ?? '___' }}</span></li>
                        @if(!empty($data['page1']['family_planning']['methods']))
                            @foreach($data['page1']['family_planning']['methods'] as $method => $count)
                                <li class="sub-item"><span>{{ strtoupper($method) }}:</span> <span>{{ $count }}</span></li>
                            @endforeach
                        @endif
                    </ul>

                    <div class="section-title">Child Health</div>
                    <ul class="data-list">
                        <li><span><strong>Total Enrolled:</strong></span> <span>{{ $data['page1']['child_health']['total_enrolled'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>FIC:</span> <span>{{ $data['page1']['child_health']['fic'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>CIC:</span> <span>{{ $data['page1']['child_health']['cic'] ?? '___' }}</span></li>
                        <li><span><strong>With Weight/Height:</strong></span> <span>{{ $data['page1']['child_health']['with_weight_height'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Normal:</span> <span>{{ $data['page1']['child_health']['nutrition']['normal'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Underweight:</span> <span>{{ $data['page1']['child_health']['nutrition']['underweight'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Severely UW:</span> <span>{{ $data['page1']['child_health']['nutrition']['severely_underweight'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Overweight:</span> <span>{{ $data['page1']['child_health']['nutrition']['overweight'] ?? '___' }}</span></li>
                        <li class="sub-item"><span>Obese:</span> <span>{{ $data['page1']['child_health']['nutrition']['obese'] ?? '___' }}</span></li>
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
    @php
        // 1. SETTINGS
        $maxPerPage = 8; // Number of barangays per page
        
        // 2. CHUNK DATA
        // We use 'true' to preserve the array index keys so we can match data correctly
        $barangayChunks = array_chunk($data['barangays'], $maxPerPage, true);
        $totalPages = count($barangayChunks);
    @endphp

    @foreach($barangayChunks as $chunkIndex => $currentBarangays)

        <div class="p2-body {{ !$loop->last ? 'page-break' : '' }}">
            
            <div class="header">
                <h1>DEMOGRAPHIC DATA BY AGE GROUP</h1>
                <h2>YEAR 2025 - Municipal Health Office</h2>
                <small>Page {{ $loop->iteration }} of {{ $loop->count }}</small>
                @if($data['startDate'] || $data['endDate'])
                <h2>Period: {{ $data['startDate'] ?? 'N/A' }} - {{ $data['endDate'] ?? 'N/A' }}</h2>
                @endif
            </div>

            <table class="p2-table">
                <thead>
                    <tr>
                        <th>Municipality</th>
                        
                        @foreach($currentBarangays as $key => $barangayName)
                            <th>{{ $barangayName }}</th>
                        @endforeach

                        @if($loop->last)
                            <th>TOTAL</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($data['page2']['summary'] as $item)
                    <tr class="category-row">
                        <td>{{ $item['label'] }}</td>
                        
                        @foreach($currentBarangays as $key => $val)
                            <td>{{ $item['barangay_data'][$key] ?? 0 }}</td>
                        @endforeach

                        @if($loop->parent->last)
                            <td class="total-column">{{ $item['total'] }}</td>
                        @endif
                    </tr>
                    @endforeach

                    <tr class="section-header">
                        <td colspan="{{ count($currentBarangays) + ($loop->last ? 2 : 1) }}">
                            AGE GROUPING
                        </td>
                    </tr>

                    @foreach($data['page2']['age_grouping'] as $group)
                        
                        @if(isset($group['is_header']) && $group['is_header'])
                            <tr class="category-row">
                                <td colspan="{{ count($currentBarangays) + ($loop->parent->last ? 2 : 1) }}" style="text-align:left !important;">
                                    {{ $group['label'] }}
                                </td>
                            </tr>
                        @else
                            <tr class="sub-item">
                                <td>{{ $group['label'] }}</td>
                                
                                @foreach($currentBarangays as $key => $val)
                                    <td>{{ $group['barangay_data'][$key] ?? 0 }}</td>
                                @endforeach

                                @if($loop->parent->last)
                                    <td class="total-column">{{ $group['total'] }}</td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            @if($loop->last)
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
                            <span class="title">Municipal Health Officer</span>
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
                   
                </table>
            @endif
        </div>
    @endforeach


    <div class="page-break"></div>
    
    {{--
    <div class="p3-body">
        <div class="header">
            <h1>DEMOGRAPHIC DATA BY AGE & BARANGAY</h1>
            <h2>YEAR 2025 - Municipal Health Office</h2>
            @if($data['startDate'] || $data['endDate'])
            <h2>Period: {{ $data['startDate'] ?? 'N/A' }} - {{ $data['endDate'] ?? 'N/A' }}</h2>
            @endif
        </div>

        <table class="p3-table">
            <thead>
                <tr>
                    <th>Age</th>
                    @foreach($data['page3']['barangays'] as $barangayName)
                        <th>{{ $barangayName }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $barangayTotals = array_fill_keys($data['page3']['barangays'], 0);
                    $grandTotal = 0;
                    $maleGrandTotal = 0;
                    $femaleGrandTotal = 0;
                @endphp
                @foreach($data['page3']['ages'] as $age)
                    <tr class="age-row">
                        <td>{{ $age }}</td>

                        @php $rowTotal = 0; @endphp

                        @foreach($data['page3']['barangays'] as $barangayName)
                            @php
                                $maleCount = $data['page3']['malePerBarangay'][$barangayName][$age] ?? 0;
                                $femaleCount = $data['page3']['femalePerBarangay'][$barangayName][$age] ?? 0;
                                $totalCount = $maleCount + $femaleCount;

                                // Accumulate totals
                                $rowTotal += $totalCount;
                                $barangayTotals[$barangayName] += $totalCount;
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
                    @foreach($data['page3']['barangays'] as $barangayName)
                        <td><strong>{{ $barangayTotals[$barangayName] }}</strong></td>
                    @endforeach
                    <td class="total-column"><strong>{{ $grandTotal }}</strong></td>
                </tr>
                <tr class="category-row">
                    <td><strong>Male Total</strong></td>
                    <td colspan="{{ count($data['page3']['barangays']) }}" style="text-align: right;"></td>
                    <td class="total-column"><strong>{{ $maleGrandTotal }}</strong></td>
                </tr>
                <tr class="category-row">
                    <td><strong>Female Total</strong></td>
                    <td colspan="{{ count($data['page3']['barangays']) }}" style="text-align: right;"></td>
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
                    <span class="title">Municipal Health Officer</span>
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
                    <span class="title">Provincial Health Officer</span>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
        --}}
</body>
</html>
