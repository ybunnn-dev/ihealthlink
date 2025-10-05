<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Midwife;
use App\Models\Resident;
use App\Models\Household;
use App\Models\Family;
use App\Models\Purok;

class BarangayReportsController extends Controller
{   
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $reportType = $request->input('report_type');

        // if no report type -> default to demographic
        if (empty($reportType)) {
            return $this->returnDemographic($startDate, $endDate);
        }

        // You can extend later for other report types here
        switch ($reportType) {
            case 'demographic':
                return $this->returnDemographic($startDate, $endDate);
            // case 'prenatal': return $this->returnPrenatalReport($startDate, $endDate);
            default:
                return $this->returnDemographic($startDate, $endDate);
        }
    }
    public function returnDemographic($startDate = null, $endDate = null)
    {
        $user = auth()->user();

        // Determine if user is Midwife or BHW with granted access
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = Midwife::where('user_id', $user->id)->first();
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $brgyId = $personnel->brgy_id;

        /**
         * FILTER CONDITIONS
         */
        $residentFilter = function ($query) use ($startDate, $endDate) {
            $query->where('status', 'active');

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }
        };

        $generalFilter = function ($query) use ($startDate, $endDate) {
            $query->where('status', 'active');
            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }
        };

        /**
         * RESIDENT STATISTICS
         */
        $residents = Resident::whereHas('family.household.purok', function ($q) use ($brgyId) {
            $q->where('brgy_id', $brgyId);
        })
        ->where($residentFilter);

        $totalResidents = $residents->count();

        /**
         * HOUSEHOLDS AND FAMILIES COUNT (TOTAL)
         */
        $households = Household::whereHas('purok', function ($q) use ($brgyId) {
            $q->where('brgy_id', $brgyId);
        })->where($generalFilter)->count();

        $households4sanitary = Household::whereHas('purok', function ($q) use ($brgyId) {
            $q->where('brgy_id', $brgyId);
        })->where($generalFilter)->get(); // <-- get() returns a collection

        $families = Family::whereHas('household.purok', function ($q) use ($brgyId) {
            $q->where('brgy_id', $brgyId);
        })->where($generalFilter)->count();

        /**
         * PER PUROK DATA
         */
     // Now use them
        $puroks = Purok::where('brgy_id', $brgyId)->with([
            'households' => function ($h) use ($generalFilter, $residentFilter) {
                $h->where($generalFilter)->with([
                    'families' => function ($f) use ($generalFilter, $residentFilter) {
                        $f->where($generalFilter)->with([
                            'residents' => function ($r) use ($residentFilter) {
                                $r->where($residentFilter);
                            }
                        ]);
                    }
                ]);
            }
        ])->get();

        $residentsPerPurok = [];
        $householdsPerPurok = [];
        $familiesPerPurok = [];
        $families4PsPerPurok = [];
        $familiesIndigentPerPurok = [];
        $malesPerPurok = [];
        $femalesPerPurok = [];

        foreach ($puroks as $purok) {
            $purokName = $purok->name;

            $householdsCount = $purok->households->count();
            $householdsPerPurok[$purokName] = $householdsCount;

            $residentsCollection = $purok->households->flatMap(fn($h) =>
                $h->families->flatMap->residents
            );

            $residentsPerPurok[$purokName] = $residentsCollection->count();

            $familiesCollection = $purok->households->flatMap->families;
            $familiesPerPurok[$purokName] = $familiesCollection->count();

            $families4PsPerPurok[$purokName] = $familiesCollection->where('is_4ps', true)->count();
            $familiesIndigentPerPurok[$purokName] = $familiesCollection->where('is_indigent', true)->count();

            $malesPerPurok[$purokName] = $residentsCollection->where('sex', 'male')->count();
            $femalesPerPurok[$purokName] = $residentsCollection->where('sex', 'female')->count();

            $pwdsPerPurok[$purokName] = $residentsCollection->where('is_pwd', true)->count();
            $nonPwdsPerPurok[$purokName] = $residentsCollection->where('is_pwd', false)->count();

            $malePwdsPerPurok[$purokName] = $residentsCollection
                ->where('sex', 'male')
                ->where('is_pwd', true)
                ->count();

            $femalePwdsPerPurok[$purokName] = $residentsCollection
                ->where('sex', 'female')
                ->where('is_pwd', true)
                ->count();
                }

        /**
         * AGE GROUPS
         */
        $ageGroups = [
            '0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39',
            '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75-79',
            '80-84', '85+'
        ];

        $maleData = [];
        $femaleData = [];

        foreach ($ageGroups as $range) {
            [$min, $max] = explode('-', str_replace('+', '', $range)) + [null, null];

            $query = (clone $residents)->whereRaw("
                TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= ?
                " . ($max ? "AND TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= ?" : ""),
                $max ? [$min, $max] : [$min]
            );

            $maleCount = (clone $query)->where('sex', 'Male')->count();
            $femaleCount = (clone $query)->where('sex', 'Female')->count();

            $maleData[] = $maleCount;
            $femaleData[] = $femaleCount;
        }

        $wasteDisposalData = $households4sanitary->groupBy('waste_disposal')->map->count()->toArray();
        $waterSourceData = $households4sanitary->groupBy('water_source')->map->count()->toArray();
        
        $sanitaryData = [
            'with_sanitary_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'with_sanitary_toilet')->count(),
            'with_unsanitary_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'with_unsanitary_toilet')->count(),
            'without_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'without_toilet')->count(),
        ];


        return view('midwife.reports', [
            'residents' => $totalResidents,
            'families' => $families,
            'households' => $households,

            'residentsPerPurok' => $residentsPerPurok,
            'householdsPerPurok' => $householdsPerPurok,
            'familiesPerPurok' => $familiesPerPurok,
            'families4PsPerPurok' => $families4PsPerPurok,
            'familiesIndigentPerPurok' => $familiesIndigentPerPurok,
            'malesPerPurok' => $malesPerPurok,
            'femalesPerPurok' => $femalesPerPurok,
            'pwdsPerPurok' => $pwdsPerPurok,
            'nonPwdsPerPurok' => $nonPwdsPerPurok,
            'malePwdsPerPurok' => $malePwdsPerPurok,
            'femalePwdsPerPurok' => $femalePwdsPerPurok,

            'ageGroups' => $ageGroups,
            'maleData' => $maleData,
            'femaleData' => $femaleData,

            'wasteDisposal' => $wasteDisposalData,
            'waterSource' => $waterSourceData,
            'sanitaryData' => $sanitaryData
        ]);
    }

    public function previewCommunityReport(Request $request)
    {
        // You can fetch data based on the request parameters if needed
        // For example: $year = $request->input('coverage');
        // For now, we'll use the same static data as before.
        $data = $this->generateCommunityReport(); // Helper function to get the data

        $pdf = Pdf::loadView('reports.combined_community_report', ['data' => $data]);
        $pdf->setPaper('Legal', 'portrait');

        // Use stream() instead of download()
        // This sends the PDF to the browser for inline display.
        return $pdf->stream('report_preview.pdf');
    }

    public function downloadCommunityReport(Request $request)
    {
        $data = $this->generateCommunityReport();

        $pdf = Pdf::loadView('reports.combined_community_report', ['data' => $data])
                ->setPaper('Legal', 'portrait');

        return $pdf->download('Barangay-Tagas-Report-2025.pdf');
    }
    private function generateCommunityReport()
    {
        return [
            'page1' => [
                'population' => [
                    'total' => 7376,
                    'male' => 3676,
                    'female' => 3700,
                ],
                'households' => [
                    'total' => 1841,
                    'indigent' => 300,
                    'non_indigent' => 1541,
                ],
                'families' => 2188,
                'four_ps' => 114,
                'seniors' => [
                    'total' => 1025,
                    'male' => 456,
                    'female' => 569,
                ],
                'pwd' => [
                    'total' => 174,
                    'male' => 73,
                    'female' => 101,
                ],
                'wra' => 1978,
                'pregnant' => [
                    'total' => null, // placeholder (fetch from DB later)
                ],
                'lactating' => null, // placeholder
                'age_sex_distribution' => [
                    ['group' => '70 & up', 'male' => 175, 'female' => 255],
                    ['group' => '65-69', 'male' => 124, 'female' => 141],
                    ['group' => '60-64', 'male' => 157, 'female' => 173],
                    ['group' => '55-59', 'male' => 181, 'female' => 201],
                    ['group' => '50-54', 'male' => 221, 'female' => 224],
                    ['group' => '45-49', 'male' => 213, 'female' => 238],
                    ['group' => '40-44', 'male' => 285, 'female' => 275],
                    ['group' => '35-39', 'male' => 288, 'female' => 287],
                    ['group' => '30-34', 'male' => 306, 'female' => 302],
                    ['group' => '25-29', 'male' => 320, 'female' => 297],
                    ['group' => '20-24', 'male' => 300, 'female' => 300],
                    ['group' => '15-19', 'male' => 316, 'female' => 279],
                    ['group' => '10-14', 'male' => 331, 'female' => 302],
                    ['group' => '5-9', 'male' => 262, 'female' => 247],
                    ['group' => '1-4', 'male' => 171, 'female' => 141],
                    ['group' => '6-11 mos', 'male' => 23, 'female' => 13],
                    ['group' => '0-5 mos', 'male' => 13, 'female' => 25],
                ],
                'sanitation' => [
                    'with_sanitary' => 1818,
                    'with_unsanitary' => 2,
                    'without' => 21,
                ],
                'water' => [
                    'pumpwell' => 113,
                    'open_well' => 3,
                    'purified' => 1841,
                    'tap' => 1725,
                ],
            ],

            'page2' => [
                'summary' => [
                    ['label' => 'No. of Households', 'purok_data' => [165, 193, 140, 223, 121, 116, 56, 175, 216, 436], 'total' => 1841],
                    ['label' => 'No. of Families', 'purok_data' => [226, 244, 177, 283, 133, 139, 67, 195, 226, 478], 'total' => 2168],
                    ['label' => 'No. of Males', 'purok_data' => [386, 490, 309, 475, 208, 222, 104, 323, 535, 624], 'total' => 3676],
                    ['label' => 'No. of Females', 'purok_data' => [406, 495, 295, 457, 207, 211, 101, 350, 498, 680], 'total' => 3700],
                    ['label' => 'No. of Individuals', 'purok_data' => [792, 985, 604, 932, 415, 433, 205, 673, 1033, 1304], 'total' => 7376],
                ],

                'age_grouping' => [
                    ['is_header' => true, 'label' => 'No. of Infants'],
                    ['label' => 'Male 0-6 mos. Olds', 'purok_data' => [0, 1, 0, 5, 2, 1, 0, 0, 3, 1], 'total' => 13],
                    ['label' => 'Female 0-6 mos. Olds', 'purok_data' => [2, 3, 4, 0, 0, 6, 1, 4, 1, 4], 'total' => 25],
                    ['label' => 'Male 6-11 mos. Olds', 'purok_data' => [3, 4, 1, 4, 2, 2, 0, 1, 4, 2], 'total' => 23],
                    ['label' => 'Female 6-11 mos. Olds', 'purok_data' => [0, 2, 0, 2, 0, 1, 0, 1, 5, 2], 'total' => 13],

                    ['is_header' => true, 'label' => 'No. of Children'],
                    ['label' => 'Male 12-59 mos old (1-4 y/o)', 'purok_data' => [16, 14, 22, 29, 6, 16, 4, 12, 32, 20], 'total' => 171],
                    ['label' => 'Female 12-59 mos old (1-4 y/o)', 'purok_data' => [26, 24, 26, 38, 18, 21, 7, 13, 56, 33], 'total' => 262],
                    ['label' => 'Male 60-119 mos old (5-9 y/o)', 'purok_data' => [13, 21, 9, 24, 6, 10, 2, 7, 32, 17], 'total' => 141],
                    ['label' => 'Female 60-119 mos old (5-9 y/o)', 'purok_data' => [30, 39, 21, 33, 13, 14, 6, 19, 53, 19], 'total' => 247],

                    ['is_header' => true, 'label' => 'No. of Adolescents'],
                    ['label' => 'Male 10-14 y/o', 'purok_data' => [34, 29, 29, 60, 20, 19, 16, 24, 61, 43], 'total' => 331],
                    ['label' => 'Female 10-14 y/o', 'purok_data' => [37, 42, 25, 45, 13, 14, 17, 17, 51, 51], 'total' => 316],
                    ['label' => 'Male 15-19 y/o', 'purok_data' => [34, 42, 23, 44, 18, 25, 14, 18, 55, 29], 'total' => 302],
                    ['label' => 'Female 15-19 y/o', 'purok_data' => [24, 41, 26, 45, 19, 11, 7, 29, 41, 36], 'total' => 279],

                    ['is_header' => true, 'label' => 'No. of Adults'],
                    ['label' => 'Male 20-59 y/o', 'purok_data' => [225, 312, 173, 251, 120, 129, 40, 205, 296, 352], 'total' => 2103],
                    ['label' => 'Female 20-59 y/o', 'purok_data' => [242, 291, 165, 253, 115, 113, 54, 201, 273, 417], 'total' => 2124],
                    ['label' => 'Female 15-49 y/o (GIDA)', 'purok_data' => [213, 296, 173, 248, 110, 117, 47, 187, 299, 328], 'total' => 2028],
                    ['label' => 'Male 50-59 y/o (GIDA)', 'purok_data' => [49, 58, 29, 48, 24, 26, 10, 35, 48, 75], 'total' => 392],
                    ['label' => 'Female 15-49 y/o (GIDA)', 'purok_data' => [217, 271, 158, 246, 110, 111, 51, 185, 268, 361], 'total' => 1978],
                    ['label' => '50-59 y/o (GIDA)', 'purok_data' => [49, 61, 33, 52, 24, 13, 10, 45, 46, 92], 'total' => 425],

                    ['is_header' => true, 'label' => 'No. of Senior Citizens'],
                    ['label' => 'Male 60 y/o and above', 'purok_data' => [46, 66, 31, 43, 28, 22, 14, 51, 32, 123], 'total' => 456],
                    ['label' => 'Female 60 y/o and above', 'purok_data' => [60, 55, 50, 52, 34, 35, 17, 75, 38, 153], 'total' => 569],

                    ['is_header' => true, 'label' => 'No. of WRA'],
                    ['label' => 'Actual', 'purok_data' => [217, 271, 158, 246, 110, 111, 51, 185, 268, 361], 'total' => 1978],

                    ['is_header' => true, 'label' => 'No. of PWDs'],
                    ['label' => 'Male', 'purok_data' => [11, 11, 4, 11, 3, 0, 6, 3, 10, 14], 'total' => 73],
                    ['label' => 'Female', 'purok_data' => [8, 11, 10, 18, 6, 5, 5, 2, 17, 19], 'total' => 101],
                ],

                'projected_population' => '7,934',
            ],
        ];
    }
        public function exportCommunityReportExcel()
    {
        $data = $this->generateCommunityReport();
        $spreadsheet = new Spreadsheet();

        // --- Process Page 1 Data ---
        $this->populatePage1Sheet($spreadsheet->getActiveSheet(), $data['page1']);

        // --- Process Page 2 Data ---
        $page2Sheet = $spreadsheet->createSheet();
        $this->populatePage2Sheet($page2Sheet, $data['page2']);

        // --- Prepare for Download ---
        $fileName = 'Community-Report-' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function populatePage1Sheet(Worksheet $sheet, array $data)
    {
        $sheet->setTitle('Community Profile');
        $row = 1;

        $sheet->setCellValue('A' . $row, 'Community Profile Report')->mergeCells('A' . $row . ':D' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(16);
        $row += 2;

        // Helper to write sections with nested key-value pairs
        $writeSection = function($title, $items) use ($sheet, &$row) {
            $sheet->setCellValue('A' . $row, $title)->getStyle('A' . $row)->getFont()->setBold(true);
            $row++;
            foreach ($items as $key => $value) {
                $sheet->setCellValue('B' . $row, str_replace('_', ' ', ucfirst($key)));
                $sheet->setCellValue('C' . $row, is_array($value) ? $value['total'] ?? $value : $value);
                $row++;
            }
            $row++; // Add a blank line after the section
        };
        
        // --- Write all sections from Page 1 ---
        $writeSection('Population', $data['population']);
        $writeSection('Households', $data['households']);
        $writeSection('Seniors', $data['seniors']);
        $writeSection('PWD', $data['pwd']);

        $sheet->setCellValue('A' . $row, 'Other Indicators')->getStyle('A' . $row)->getFont()->setBold(true);
        $row++;
        $sheet->setCellValue('B' . $row, 'Total Families');
        $sheet->setCellValue('C' . $row, $data['families']); $row++;
        $sheet->setCellValue('B' . $row, '4Ps Beneficiaries');
        $sheet->setCellValue('C' . $row, $data['four_ps']); $row++;
        $sheet->setCellValue('B' . $row, 'Women of Reproductive Age (WRA)');
        $sheet->setCellValue('C' . $row, $data['wra']); $row++;
        $sheet->setCellValue('B' . $row, 'Pregnant');
        $sheet->setCellValue('C' . $row, $data['pregnant']['total'] ?? 'N/A'); $row++;
        $sheet->setCellValue('B' . $row, 'Lactating');
        $sheet->setCellValue('C' . $row, $data['lactating'] ?? 'N/A'); $row++;
        $row++;

        $writeSection('Household Sanitation', $data['sanitation']);
        $writeSection('Household Water Source', $data['water']);

        // --- Age & Sex Distribution Table ---
        $sheet->setCellValue('A' . $row, 'Age & Sex Distribution')->getStyle('A' . $row)->getFont()->setBold(true);
        $row++;
        $sheet->setCellValue('B' . $row, 'Age Group')->getStyle('B' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('C' . $row, 'Male')->getStyle('C' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('D' . $row, 'Female')->getStyle('D' . $row)->getFont()->setBold(true);
        $row++;
        foreach ($data['age_sex_distribution'] as $distData) {
            $sheet->setCellValue('B' . $row, $distData['group']);
            $sheet->setCellValue('C' . $row, $distData['male']);
            $sheet->setCellValue('D' . $row, $distData['female']);
            $row++;
        }
        $row++;

        // Auto-size columns for readability
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function populatePage2Sheet(Worksheet $sheet, array $data)
    {
        $sheet->setTitle('Purok Data');
        $row = 1;

        $sheet->setCellValue('A' . $row, 'Summary Data by Purok')->mergeCells('A' . $row . ':L' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(16);
        $row += 2;

        // Helper to write the complex purok tables
        $writePurokTable = function($title, $tableData) use ($sheet, &$row) {
             if (empty($tableData)) return;
             $sheet->setCellValue('A' . $row, $title)->getStyle('A' . $row)->getFont()->setBold(true);
             $row++;

             // Write Headers
             $headers = ['Label'];
             $numPuroks = count($tableData[0]['purok_data'] ?? []);
             for ($i = 1; $i <= $numPuroks; $i++) {
                 $headers[] = 'Purok ' . $i;
             }
             $headers[] = 'Total';
             $sheet->fromArray($headers, null, 'A' . $row);
             $lastHeaderCol = $sheet->getHighestColumn();
             $sheet->getStyle('A'.$row.':'. $lastHeaderCol . $row)->getFont()->setBold(true);
             $row++;

             // Write Data
             foreach ($tableData as $dataRow) {
                 if (isset($dataRow['is_header']) && $dataRow['is_header']) {
                     $sheet->setCellValue('A' . $row, $dataRow['label'])->mergeCells('A'.$row.':'.$lastHeaderCol.$row);
                     $sheet->getStyle('A' . $row)->getFont()->setBold(true);
                 } else {
                     $rowData = array_merge([$dataRow['label']], $dataRow['purok_data'], [$dataRow['total']]);
                     $sheet->fromArray($rowData, null, 'A' . $row);
                 }
                 $row++;
             }
             $row++; // Spacer row
        };

        $writePurokTable('Summary', $data['summary']);
        $writePurokTable('Age Grouping', $data['age_grouping']);
        
        $sheet->setCellValue('A' . $row, 'Projected Population:')->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('B' . $row, $data['projected_population']);

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
     public function exportCommunityReportCsv()
    {
        $data = $this->generateCommunityReport();
        $fileName = 'Community-Report-' . date('Y-m-d') . '.csv';

        // Set headers to force a download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');

        // Open the output stream
        $handle = fopen('php://output', 'w');

        // --- SECTION 1: PAGE 1 DATA ---
        fputcsv($handle, ['COMMUNITY PROFILE REPORT (PAGE 1)']);
        fputcsv($handle, []); // Blank line for spacing

        // Write simple key-value sections
        $this->writeKeyValueSectionToCsv($handle, 'Population', $data['page1']['population']);
        $this->writeKeyValueSectionToCsv($handle, 'Households', $data['page1']['households']);
        $this->writeKeyValueSectionToCsv($handle, 'Seniors', $data['page1']['seniors']);
        $this->writeKeyValueSectionToCsv($handle, 'PWD', $data['page1']['pwd']);
        
        // Write other indicators
        fputcsv($handle, ['Other Indicators']);
        fputcsv($handle, ['Total Families', $data['page1']['families']]);
        fputcsv($handle, ['4Ps Beneficiaries', $data['page1']['four_ps']]);
        fputcsv($handle, ['Women of Reproductive Age (WRA)', $data['page1']['wra']]);
        fputcsv($handle, ['Pregnant', $data['page1']['pregnant']['total'] ?? 'N/A']);
        fputcsv($handle, ['Lactating', $data['page1']['lactating'] ?? 'N/A']);
        fputcsv($handle, []);

        // Write Age & Sex Distribution table
        fputcsv($handle, ['Age & Sex Distribution']);
        fputcsv($handle, ['Age Group', 'Male', 'Female']);
        foreach ($data['page1']['age_sex_distribution'] as $row) {
            fputcsv($handle, [$row['group'], $row['male'], $row['female']]);
        }
        fputcsv($handle, []);

        $this->writeKeyValueSectionToCsv($handle, 'Household Sanitation', $data['page1']['sanitation']);
        $this->writeKeyValueSectionToCsv($handle, 'Household Water Source', $data['page1']['water']);


        // --- SECTION 2: PAGE 2 DATA ---
        fputcsv($handle, []);
        fputcsv($handle, []); // Add extra spacing
        fputcsv($handle, ['PUROK DATA SUMMARY (PAGE 2)']);
        fputcsv($handle, []);

        $this->writePurokTableToCsv($handle, 'Summary', $data['page2']['summary']);
        $this->writePurokTableToCsv($handle, 'Age Grouping', $data['page2']['age_grouping']);
        
        fputcsv($handle, ['Projected Population', $data['page2']['projected_population']]);

        // Close the stream
        fclose($handle);
        exit;
    }

    /**
     * Helper function to write simple key-value data to the CSV.
     */
    private function writeKeyValueSectionToCsv($handle, $title, $data)
    {
        fputcsv($handle, [$title]);
        foreach ($data as $key => $value) {
            // Format the key to be more readable
            $formattedKey = str_replace('_', ' ', ucfirst($key));
            $outputValue = is_array($value) ? ($value['total'] ?? implode(', ', $value)) : $value;
            fputcsv($handle, [$formattedKey, $outputValue]);
        }
        fputcsv($handle, []); // Blank line for spacing
    }

    /**
     * Helper function to write the complex purok tables to the CSV.
     */
    private function writePurokTableToCsv($handle, $title, $tableData)
    {
        if (empty($tableData)) return;

        fputcsv($handle, [$title]);

        // Generate and write headers
        $headers = ['Label'];
        $numPuroks = count($tableData[0]['purok_data'] ?? []);
        for ($i = 1; $i <= $numPuroks; $i++) {
            $headers[] = 'Purok ' . $i;
        }
        $headers[] = 'Total';
        fputcsv($handle, $headers);

        // Write data rows
        foreach ($tableData as $dataRow) {
            if (isset($dataRow['is_header']) && $dataRow['is_header']) {
                // For section headers within the table, just write the label
                fputcsv($handle, [$dataRow['label']]);
            } else {
                // For data rows, combine all parts into one array and write
                $rowData = array_merge([$dataRow['label']], $dataRow['purok_data'], [$dataRow['total']]);
                fputcsv($handle, $rowData);
            }
        }
        fputcsv($handle, []); // Blank line for spacing
    }
}
