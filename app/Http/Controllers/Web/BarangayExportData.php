<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Models\Barangay; // Assuming you have a Barangay model
use App\Models\Resident; // Assuming you have a Resident model
use App\Models\Consultation; // Added Consultation model

use Barryvdh\DomPDF\Facade\Pdf;

class BarangayExportData extends Controller
{   public function previewCommunityReport(Request $request)
    {
        $startDate = $request->query('startDate'); 
        $endDate = $request->query('endDate');

        $data = $this->generateCommunityReport($startDate, $endDate); 

        $pdf = Pdf::loadView('reports.combined_community_report', ['data' => $data]);
        $pdf->setPaper('Legal', 'portrait');

        
        return $pdf->stream('report_preview.pdf');
    }

   
    private function generateCommunityReport($startDate = null, $endDate = null)
    {
        $barangay = Auth::user()->barangay;

        $reportController = app(BarangayReportsController::class);
        $data = $reportController->returnDemographic($startDate, $endDate);

        $page2 = [
            'summary' => [
                [
                    'label' => 'No. of Households',
                    'purok_data' => array_values($data['householdsPerPurok']),
                    'total' => $data['households'],
                ],
                [
                    'label' => 'No. of Families',
                    'purok_data' => array_values($data['familiesPerPurok']),
                    'total' => $data['families'],
                ],
                [
                    'label' => 'No. of Males',
                    'purok_data' => array_values($data['malesPerPurok']),
                    'total' => array_sum($data['maleData']),
                ],
                [
                    'label' => 'No. of Females',
                    'purok_data' => array_values($data['femalesPerPurok']),
                    'total' => array_sum($data['femaleData']),
                ],
                [
                    'label' => 'No. of Individuals',
                    'purok_data' => array_map(
                        fn($k, $v) => $v + ($data['femalesPerPurok'][$k] ?? 0),
                        array_keys($data['residentsPerPurok']),
                        $data['residentsPerPurok']
                    ),
                    'total' => $data['residents'],
                ],
            ],
            'age_grouping' => [],
            'projected_population' => number_format($data['residents']),
        ];

        // Define headers dynamically based on age groups
        $headers = [
            '0-11 months' => 'No. of Infants',
            '1-9 years' => 'No. of Children',
            '10-19 years' => 'No. of Adolescents',
            '20-59 years' => 'No. of Adults',
            '60+ years' => 'No. of Senior Citizens',
        ];

        // Map each age group to a header
        $ageGroupMapping = [
            '0-6 months' => '0-11 months',
            '6-11 months' => '0-11 months',
            '1-4 years' => '1-9 years',
            '5-9 years' => '1-9 years',
            '10-14 years' => '10-19 years',
            '15-19 years' => '10-19 years',
            '20-59 years' => '20-59 years',
            '60+ years' => '60+ years',
        ];

        $page3 = [
            'page3' => 1,
            'puroks' => $data['puroks'],
            'ages' => range(1, 100),
            'malePerPurok' => [],
            'femalePerPurok' => [],
        ];

        foreach ($data['puroks'] as $purokName) {
            $page3['malePerPurok'][$purokName] = [];
            $page3['femalePerPurok'][$purokName] = [];

            foreach ($page3['ages'] as $age) {
                $page3['malePerPurok'][$purokName][$age] = $data['maleAgePerPurok'][$purokName][$age] ?? 0;
                $page3['femalePerPurok'][$purokName][$age] = $data['femaleAgePerPurok'][$purokName][$age] ?? 0;
            }
        }

        $addedHeaders = [];

        foreach ($data['ageGroups'] as $index => $ageRange) {
            $headerKey = $ageGroupMapping[$ageRange] ?? null;
            if ($headerKey && !in_array($headerKey, $addedHeaders)) {
                $page2['age_grouping'][] = [
                    'is_header' => true,
                    'label' => $headers[$headerKey] ?? $headerKey,
                ];
                $addedHeaders[] = $headerKey;
            }

            $malePurokData = array_values(array_map(fn($v) => $v[$index] ?? 0, $data['ageGroupMalePerPurok']));
            $femalePurokData = array_values(array_map(fn($v) => $v[$index] ?? 0, $data['ageGroupFemalePerPurok']));

            $page2['age_grouping'][] = [
                'label' => 'Male ' . $ageRange,
                'purok_data' => $malePurokData,
                'total' => array_sum($malePurokData),
            ];

            $page2['age_grouping'][] = [
                'label' => 'Female ' . $ageRange,
                'purok_data' => $femalePurokData,
                'total' => array_sum($femalePurokData),
            ];
        }

        // Add WRA
        $page2['age_grouping'][] = ['is_header' => true, 'label' => 'No. of WRA'];
        $page2['age_grouping'][] = [
            'label' => 'Actual',
            'purok_data' => array_values($data['wraPerPurok']),
            'total' => array_sum($data['wraPerPurok']),
        ];

        // Add Pregnant Women
        $page2['age_grouping'][] = ['is_header' => true, 'label' => 'No. of Pregnant Women'];
        $page2['age_grouping'][] = [
            'label' => 'Actual',
            'purok_data' => array_values($data['pregnantPerPurok']),
            'total' => array_sum($data['pregnantPerPurok']),
        ];

        // Add Lactating Mothers
        $page2['age_grouping'][] = ['is_header' => true, 'label' => 'No. of Lactating Mothers'];
        $page2['age_grouping'][] = [
            'label' => 'Actual',
            'purok_data' => array_values($data['lactatingPerPurok']),
            'total' => array_sum($data['lactatingPerPurok']),
        ];

        // Add PWDs
        $page2['age_grouping'][] = ['is_header' => true, 'label' => 'No. of PWDs'];
        $page2['age_grouping'][] = [
            'label' => 'Male',
            'purok_data' => array_values($data['malePwdsPerPurok']),
            'total' => array_sum($data['malePwdsPerPurok']),
        ];
        $page2['age_grouping'][] = [
            'label' => 'Female',
            'purok_data' => array_values($data['femalePwdsPerPurok']),
            'total' => array_sum($data['femalePwdsPerPurok']),
        ];

        return [
            'barangay_name' => $barangay->name,
            'page1' => [
                'population' => [
                    'total' => $data['residents'],
                    'male' => array_sum($data['maleData']),
                    'female' => array_sum($data['femaleData']),
                ],
                'startDate' => $startDate ? Carbon::parse($startDate)->format('F d, Y') : null,
                'endDate' => $endDate ? Carbon::parse($endDate)->format('F d, Y') : null,
                'households' => [
                    'total' => $data['households'],
                    'indigent' => array_sum($data['familiesIndigentPerPurok']),
                    'non_indigent' => $data['families'] - array_sum($data['familiesIndigentPerPurok']),
                ],
                'families' => $data['families'],
                'four_ps' => array_sum($data['families4PsPerPurok']),
                'seniors' => $data['seniors'],
                'pwd' => [
                    'total' => array_sum($data['pwdsPerPurok']),
                    'male' => array_sum($data['malePwdsPerPurok']),
                    'female' => array_sum($data['femalePwdsPerPurok']),
                ],
                'wra' => $data['wra'],
                'pregnant' => [
                    'total' => $data['pregnantWomen'],           // UPDATED
                    'teen' => $data['teenPregnancies'],          // ADDED
                    'primis' => $data['primis'],                 // ADDED
                    'multiPara' => $data['multiPara'],          // ADDED
                    'others' => $data['pregnancyOthers'],       // ADDED
                ],
                'lactating' => $data['totalLactating'],         // UPDATED
                'family_planning' => [                          // ADDED
                    'total' => $data['totalFamilyPlanningEnrollees'],
                    'methods' => $data['familyPlanningMethods'],
                ],
                'child_health' => [                             // ADDED
                    'total_enrolled' => $data['totalChildrenEnrolled'],
                    'fic' => $data['ficCount'],
                    'cic' => $data['cicCount'],
                    'with_weight_height' => $data['childrenWithWeightHeight'],
                    'nutrition' => [
                        'normal' => $data['normalWeight'],
                        'underweight' => $data['underweight'],
                        'severely_underweight' => $data['severelyUnderweight'],
                        'overweight' => $data['overweight'],
                        'obese' => $data['obese'],
                    ],
                ],
                'age_sex_distribution' => collect($data['ageGroups'])->map(function ($group, $i) use ($data) {
                    return [
                        'group' => $group,
                        'male' => $data['maleData'][$i] ?? 0,
                        'female' => $data['femaleData'][$i] ?? 0,
                    ];
                })->toArray(),
                'sanitation' => [
                    'with_sanitary' => $data['sanitaryData']['with_sanitary_toilet'] ?? 0,
                    'with_unsanitary' => $data['sanitaryData']['with_unsanitary_toilet'] ?? 0,
                    'without' => $data['sanitaryData']['without_toilet'] ?? 0,
                ],
                'water' => [
                    'pumpwell' => $data['waterSource']['Pumpwell'] ?? 0,
                    'open_well' => $data['waterSource']['Open Well'] ?? 0,
                    'purified' => $data['waterSource']['Purified Water'] ?? 0,
                    'tap' => $data['waterSource']['Tap Water'] ?? 0,
                ],
            ],

            'page2' => $page2,
            'page3' => $page3,
            'puroks' => $data['puroks'],
            'startDate' => $startDate ? Carbon::parse($startDate)->format('F d, Y') : null,
            'endDate' => $endDate ? Carbon::parse($endDate)->format('F d, Y') : null,
        ];
    }

    public function exportCommunityReportExcel(Request $request)
    {
        $startDate = $request->query('startDate'); 
        $endDate = $request->query('endDate');

        $data = $this->generateCommunityReport($startDate, $endDate);
        $spreadsheet = new Spreadsheet();

        // --- Process Page 1 Data ---
        $this->populatePage1Sheet($spreadsheet->getActiveSheet(), $data['page1']);

        // --- Process Page 2 Data ---
        $page2Sheet = $spreadsheet->createSheet();
        $this->populatePage2Sheet($page2Sheet, $data['page2']);

        $page3Sheet = $spreadsheet->createSheet();
        $this->populatePage3Sheet($page3Sheet, $data['page3']);
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
        $row = 1;

        // Merge the first row for the title
        $sheet->mergeCells("A{$row}:F{$row}");
        $sheet->setCellValue("A{$row}", 'Community Profile');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(14);
        $row++;

        // Add StartDate - EndDate below the title
        $sheet->mergeCells("A{$row}:F{$row}");
        $start = $data['startDate'] ?? '';
        $end = $data['endDate'] ?? '';
        $sheet->setCellValue("A{$row}", "{$start} - {$end}");
        $sheet->getStyle("A{$row}")->getFont()->setItalic(true);
        $row++;

        
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
        $sheet->setCellValue('B' . $row, 'Pregnant Women (Total)');
        $sheet->setCellValue('C' . $row, $data['pregnant']['total'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, '  - Teen Pregnancies');
        $sheet->setCellValue('C' . $row, $data['pregnant']['teen'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, '  - Primigravida');
        $sheet->setCellValue('C' . $row, $data['pregnant']['primis'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, '  - Multipara');
        $sheet->setCellValue('C' . $row, $data['pregnant']['multiPara'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, '  - Others');
        $sheet->setCellValue('C' . $row, $data['pregnant']['others'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, 'Lactating');
        $sheet->setCellValue('C' . $row, $data['lactating'] ?? 'N/A'); $row++;
        $row++;

        // Family Planning Section
        $sheet->setCellValue('A' . $row, 'Family Planning')->getStyle('A' . $row)->getFont()->setBold(true);
        $row++;
        $sheet->setCellValue('B' . $row, 'Total Enrollees');
        $sheet->setCellValue('C' . $row, $data['family_planning']['total'] ?? 'N/A'); 
        $row++;

        // Family Planning Methods (if available)
        if (isset($data['family_planning']['methods']) && is_array($data['family_planning']['methods'])) {
            foreach ($data['family_planning']['methods'] as $method => $count) {
                $sheet->setCellValue('B' . $row, "  - {$method}"); // Indent with spaces
                $sheet->setCellValue('C' . $row, $count);
                $row++;
            }
        }
        $row++;

        // Child Health Section
        $sheet->setCellValue('A' . $row, 'Child Health Program')->getStyle('A' . $row)->getFont()->setBold(true);
        $row++;
        $sheet->setCellValue('B' . $row, 'Total Children Enrolled');
        $sheet->setCellValue('C' . $row, $data['child_health']['total_enrolled'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, 'Fully Immunized (FIC)');
        $sheet->setCellValue('C' . $row, $data['child_health']['fic'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, 'Completely Immunized (CIC)');
        $sheet->setCellValue('C' . $row, $data['child_health']['cic'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, 'With Weight & Height Records');
        $sheet->setCellValue('C' . $row, $data['child_health']['with_weight_height'] ?? 'N/A'); 
        $row++;
        $row++;

        // Child Nutritional Status Section
        $sheet->setCellValue('A' . $row, 'Child Nutritional Status')->getStyle('A' . $row)->getFont()->setBold(true);
        $row++;
        $sheet->setCellValue('B' . $row, 'Normal Weight');
        $sheet->setCellValue('C' . $row, $data['child_health']['nutrition']['normal'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, 'Underweight');
        $sheet->setCellValue('C' . $row, $data['child_health']['nutrition']['underweight'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, 'Severely Underweight');
        $sheet->setCellValue('C' . $row, $data['child_health']['nutrition']['severely_underweight'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, 'Overweight');
        $sheet->setCellValue('C' . $row, $data['child_health']['nutrition']['overweight'] ?? 'N/A'); 
        $row++;
        $sheet->setCellValue('B' . $row, 'Obese');
        $sheet->setCellValue('C' . $row, $data['child_health']['nutrition']['obese'] ?? 'N/A'); 
        $row++;
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

    private function populatePage3Sheet(Worksheet $sheet, array $page3)
    {
        $row = 1;

        // Title
        $sheet->mergeCells("A{$row}:F{$row}");
        $sheet->setCellValue("A{$row}", 'Demographic Data by Age');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(14);
        $row++;

        // Add age range info if you want (optional)
        $sheet->mergeCells("A{$row}:F{$row}");
        $sheet->setCellValue("A{$row}", "Ages 1-100");
        $sheet->getStyle("A{$row}")->getFont()->setItalic(true);
        $row++;

        $sheet->setCellValue("A{$row}", "Age");

        $colIndex = 2; // Column B
        foreach ($page3['puroks'] as $purokName) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue("{$colLetter}{$row}", $purokName);
            $colIndex++;
        }
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue("{$colLetter}{$row}", "Total");
        $row++;

        // Data rows
        foreach ($page3['ages'] as $age) {
            $sheet->setCellValue("A{$row}", $age);
            $colIndex = 2;
            $rowTotal = 0;

            foreach ($page3['puroks'] as $purokName) {
                $male = $page3['malePerPurok'][$purokName][$age] ?? 0;
                $female = $page3['femalePerPurok'][$purokName][$age] ?? 0;
                $total = $male + $female;

                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $sheet->setCellValue("{$colLetter}{$row}", $total);
                $rowTotal += $total;
                $colIndex++;
            }

            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue("{$colLetter}{$row}", $rowTotal);
            $row++;
        }


        // Optional: set bold for header row
        $sheet->getStyle("A" . ($row - count($page3['ages']) - 1) . ":" . $sheet->getHighestColumn() . ($row - count($page3['ages']) - 1))
            ->getFont()->setBold(true);
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

    public function downloadCommunityReport(Request $request)
    {
        $startDate = $request->query('startDate'); // from URL
        $endDate = $request->query('endDate');

        $data = $this->generateCommunityReport($startDate, $endDate);

        $pdf = Pdf::loadView('reports.combined_community_report', ['data' => $data])
                ->setPaper('Legal', 'portrait');

        $barangayName = $data['barangay_name'] ?? 'Barangay';
        $reportYear = now()->format('Y'); // Or fetch from your own data as needed

        // Remove spaces or special characters for filename safety
        $barangaySlug = str_replace(' ', '-', strtolower($barangayName));
        $filename = "{$barangaySlug}-community-report-{$reportYear}.pdf";

        return $pdf->download($filename);
    }

    public function exportReferralPdf(Request $request)
    {
        // Get all the data sent from the JavaScript payload
        $data = $request->all();

        // Load the Blade view with the data
        $pdf = Pdf::loadView('reports.referral_form', ['data' => $data]);

        // (Optional) Sanitize the patient's name for a clean filename
        $patientName = $data['patientInfo']['name'] ?? 'patient';
        $safeName = preg_replace('/[^A-Za-z0-9\-]/', '_', $patientName);
        $fileName = 'Referral-Form-' . $safeName . '.pdf';

        // Return the generated PDF to the browser for download
        return $pdf->download($fileName);
    }

    public function printChildCarePdf(Request $request)
    {
        // Get the entire JSON payload from the request
        $payload = (object) $request->all();

        // Prepare the data for the view
        $data = [
            'record' => $payload
        ];

        // Generate a filename, e.g., "child-care-gusion-lodicakes-dela-cruz.pdf"
        $childNameSlug = Str::slug($payload->basicInfo['fullName'] ?? 'child-record');
        $fileName = 'child-care-' . $childNameSlug . '.pdf';

        // Load the view and pass the data to it
        $pdf = Pdf::loadView('reports.child-care-pdf', $data);

        // Download the PDF
        return $pdf->download($fileName);
    }

    public function printPhilpen(Consultation $consultation)
    {
        $user = Auth::user();

        // Determine personnel type
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        // Load personnel's barangay relationship to get health center name
        $personnel->load('barangay');

        // Ensure all necessary relationships are loaded
        $consultation->load(
            'enrolledResident.resident.family.household.purok.barangay',
            'healthSigns',
            'medicalHistory',
            'familyHistory',
            'riskAssessment',
            'ncdRiskFactor',
            'philpenManagement'
        );

        // Calculate accurate age from birthdate to consultation updated_at
        $resident = $consultation->enrolledResident->resident;
        $age = null;
        if ($resident && $resident->birthdate && $consultation->updated_at) {
            $birthDate = new \DateTime($resident->birthdate);
            $consultationDate = new \DateTime($consultation->updated_at);
            $diff = $consultationDate->diff($birthDate);
            $age = $diff->y;
        }

        // Get health center from personnel's barangay
        $healthCenter = $personnel->barangay->name ?? 'N/A';

        // Load the Blade view with the data
        $pdf = Pdf::loadView('reports.philpen_assessment', compact('consultation', 'personnel', 'age', 'healthCenter'));

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        $fileName = 'philpen-assessment-' . ($consultation->enrolledResident->resident->lastName ?? $consultation->id) . '-' . now()->format('Ymd') . '.pdf';

        return $pdf->download($fileName);
    }
}
