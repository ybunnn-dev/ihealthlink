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
            font-size: 12px; /* Set a base font size */
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
            border-bottom: 1px solid #555;
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
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .p1-table td:nth-child(2), .p1-table td:nth-child(3) { text-align: center; }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
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
            background-color: #e0e0e0;
            font-weight: bold;
        }
        .p2-table td:first-child {
            text-align: left;
            font-weight: normal;
        }
        .section-header td {
            background-color: #c0c0c0;
            font-weight: bold;
            text-align: center !important;
        }
        .category-row td {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .p2-table .sub-item td:first-child { padding-left: 15px; }
        .total-column {
            font-weight: bold;
            background-color: #e0e0e0;
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
    </style>
</head>
<body>
    <div class="p1-body">
        <div class="header">
            <h1>Barangay Tagas - Community Profile Report 2025</h1>
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
                        <li><span><strong>Lactating:</strong></span> <span>{{ $data['page1']['lactating'] ?? '___' }}</span></li>
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

    <div class="p2-body">
        <div class="header">
            <h1>DEMOGRAPHIC DATA</h1>
            <h2>YEAR 2025</h2>
        </div>
        <table class="p2-table">
            <thead>
                <tr>
                    <th>Barangay TAGAS</th>
                    @for ($i = 1; $i <= 10; $i++)
                    <th>{{ $i }}</th>
                    @endfor
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
</body>
</html>