<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{   
    /**
     * Preview the community report as PDF in the browser
     */
    public function previewCommunityReport(Request $request)
    {
        $startDate = $request->query('startDate'); 
        $endDate = $request->query('endDate');

        $data = $this->generateCommunityReport($startDate, $endDate); 

        $pdf = Pdf::loadView('reports.mho_community_report', ['data' => $data]);
        $pdf->setPaper('Legal', 'portrait');
        
        return $pdf->stream('mho_report_preview.pdf');
    }

    /**
     * Download the community report as PDF
     */
    public function downloadCommunityReport(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        $data = $this->generateCommunityReport($startDate, $endDate);

        $pdf = Pdf::loadView('reports.mho_community_report', ['data' => $data])
                ->setPaper('Legal', 'portrait');

        $fileName = 'MHO-Community-Report-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }

    /**
     * Export community report to Excel format
     */
    public function exportCommunityReportExcel(Request $request)
    {
        $startDate = $request->query('startDate'); 
        $endDate = $request->query('endDate');

        $data = $this->generateCommunityReport($startDate, $endDate);
        $spreadsheet = new Spreadsheet();

        // --- Process Page 1: Summary Data ---
        $this->populatePage1Sheet($spreadsheet->getActiveSheet(), $data['page1']);

        // --- Process Page 2: Barangay Data ---
        $page2Sheet = $spreadsheet->createSheet();
        $this->populatePage2Sheet($page2Sheet, $data['page2']);

        // --- Process Page 3: Age Distribution ---
        $page3Sheet = $spreadsheet->createSheet();
        $this->populatePage3Sheet($page3Sheet, $data['page3']);

        // --- Prepare for Download ---
        $fileName = 'MHO-Community-Report-' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generate community report data from ReportsController
     */
    private function generateCommunityReport($startDate = null, $endDate = null)
    {
        $reportController = app(ReportsController::class);
        $data = $reportController->returnDemographic($startDate, $endDate);

        // Page 1: Summary Overview
        $page1 = [
            'population' => [
                'total' => $data['residents'],
                'male' => array_sum($data['maleData']),
                'female' => array_sum($data['femaleData']),
            ],
            'startDate' => $startDate ? Carbon::parse($startDate)->format('F d, Y') : null,
            'endDate' => $endDate ? Carbon::parse($endDate)->format('F d, Y') : null,
            'households' => [
                'total' => $data['households'],
                'indigent' => array_sum($data['familiesIndigentPerBarangay']),
                'non_indigent' => $data['families'] - array_sum($data['familiesIndigentPerBarangay']),
            ],
            'families' => $data['families'],
            'four_ps' => array_sum($data['families4PsPerBarangay']),
            'seniors' => $data['seniors'],
            'pwd' => [
                'total' => array_sum($data['pwdsPerBarangay']),
                'male' => array_sum($data['malePwdsPerBarangay']),
                'female' => array_sum($data['femalePwdsPerBarangay']),
            ],
            'wra' => $data['wra'],
            'pregnant' => [
                'total' => $data['pregnantWomen'],
                'teen' => $data['teenPregnancies'],
                'primis' => $data['primis'],
                'multiPara' => $data['multiPara'],
                'others' => $data['pregnancyOthers'],
            ],
            'lactating' => $data['totalLactating'],
            'family_planning' => [
                'total' => $data['familyPlanningEnrollees'],
                'methods' => $data['familyPlanningMethods'],
            ],
            'child_health' => [
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
                'purified' => $data['waterSource']['Purified Water'] ?? $data['waterSource']['Purified'] ?? 0,
                'tap' => $data['waterSource']['Tap Water'] ?? 0,
            ],
        ];

        // Page 2: Barangay Breakdown
        $page2 = [
            'summary' => [
                [
                    'label' => 'No. of Households',
                    'barangay_data' => array_values($data['householdsPerBarangay']),
                    'total' => $data['households'],
                ],
                [
                    'label' => 'No. of Families',
                    'barangay_data' => array_values($data['familiesPerBarangay']),
                    'total' => $data['families'],
                ],
                [
                    'label' => 'No. of Males',
                    'barangay_data' => array_values($data['malesPerBarangay']),
                    'total' => array_sum($data['maleData']),
                ],
                [
                    'label' => 'No. of Females',
                    'barangay_data' => array_values($data['femalesPerBarangay']),
                    'total' => array_sum($data['femaleData']),
                ],
                [
                    'label' => 'No. of Individuals',
                    'barangay_data' => array_values($data['residentsPerBarangay']),
                    'total' => $data['residents'],
                ],
            ],
            'age_grouping' => [],
            'projected_population' => number_format($data['residents']),
        ];

        // Define age group headers
        $headers = [
            '0-11 months' => 'No. of Infants',
            '1-9 years' => 'No. of Children',
            '10-19 years' => 'No. of Adolescents',
            '20-59 years' => 'No. of Adults',
            '60+ years' => 'No. of Senior Citizens',
        ];

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

        // Page 3: Age Distribution by Barangay
        $page3 = [
            'page3' => 1,
            'barangays' => $data['barangays'],
            'ages' => range(1, 100),
            'malePerBarangay' => [],
            'femalePerBarangay' => [],
        ];

        foreach ($data['barangays'] as $barangayName) {
            $page3['malePerBarangay'][$barangayName] = [];
            $page3['femalePerBarangay'][$barangayName] = [];

            foreach ($page3['ages'] as $age) {
                $page3['malePerBarangay'][$barangayName][$age] = $data['malePerAgePerBarangay'][$barangayName][$age] ?? 0;
                $page3['femalePerBarangay'][$barangayName][$age] = $data['femalePerAgePerBarangay'][$barangayName][$age] ?? 0;
            }
        }

        // Build age grouping data
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

            $maleBarangayData = array_values(array_map(fn($v) => $v[$index] ?? 0, $data['ageGroupMalePerBarangay']));
            $femaleBarangayData = array_values(array_map(fn($v) => $v[$index] ?? 0, $data['ageGroupFemalePerBarangay']));

            $page2['age_grouping'][] = [
                'label' => 'Male ' . $ageRange,
                'barangay_data' => $maleBarangayData,
                'total' => array_sum($maleBarangayData),
            ];

            $page2['age_grouping'][] = [
                'label' => 'Female ' . $ageRange,
                'barangay_data' => $femaleBarangayData,
                'total' => array_sum($femaleBarangayData),
            ];
        }

        // Add WRA
        $page2['age_grouping'][] = ['is_header' => true, 'label' => 'No. of WRA'];
        $page2['age_grouping'][] = [
            'label' => 'Actual',
            'barangay_data' => array_values($data['wraPerBarangay']),
            'total' => array_sum($data['wraPerBarangay']),
        ];

        // Add Pregnant Women
        $page2['age_grouping'][] = ['is_header' => true, 'label' => 'No. of Pregnant Women'];
        $page2['age_grouping'][] = [
            'label' => 'Actual',
            'barangay_data' => array_values($data['pregnantPerBarangay']),
            'total' => array_sum($data['pregnantPerBarangay']),
        ];

        // Add Lactating Mothers
        $page2['age_grouping'][] = ['is_header' => true, 'label' => 'No. of Lactating Mothers'];
        $page2['age_grouping'][] = [
            'label' => 'Actual',
            'barangay_data' => array_values($data['lactatingPerBarangay']),
            'total' => array_sum($data['lactatingPerBarangay']),
        ];

        // Add PWDs
        $page2['age_grouping'][] = ['is_header' => true, 'label' => 'No. of PWDs'];
        $page2['age_grouping'][] = [
            'label' => 'Male',
            'barangay_data' => array_values($data['malePwdsPerBarangay']),
            'total' => array_sum($data['malePwdsPerBarangay']),
        ];
        $page2['age_grouping'][] = [
            'label' => 'Female',
            'barangay_data' => array_values($data['femalePwdsPerBarangay']),
            'total' => array_sum($data['femalePwdsPerBarangay']),
        ];

        return [
            'page1' => $page1,
            'page2' => $page2,
            'page3' => $page3,
            'barangays' => $data['barangays'],
            'startDate' => $startDate ? Carbon::parse($startDate)->format('F d, Y') : null,
            'endDate' => $endDate ? Carbon::parse($endDate)->format('F d, Y') : null,
        ];
    }

    /**
     * Populate Page 1 sheet with summary data
     */
    private function populatePage1Sheet(Worksheet $sheet, array $data)
    {
        $row = 1;

        // Title
        $sheet->mergeCells("A{$row}:F{$row}");
        $sheet->setCellValue("A{$row}", 'MHO Community Profile');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(14);
        $row++;

        // Date Range
        $sheet->mergeCells("A{$row}:F{$row}");
        $start = $data['startDate'] ?? '';
        $end = $data['endDate'] ?? '';
        $sheet->setCellValue("A{$row}", "{$start} - {$end}");
        $sheet->getStyle("A{$row}")->getFont()->setItalic(true);
        $row += 2;

        // Helper function to write sections
        $writeSection = function($title, $items) use ($sheet, &$row) {
            $sheet->setCellValue('A' . $row, $title)->getStyle('A' . $row)->getFont()->setBold(true);
            $row++;
            foreach ($items as $key => $value) {
                $sheet->setCellValue('B' . $row, str_replace('_', ' ', ucwords($key)));
                $sheet->setCellValue('C' . $row, is_array($value) ? ($value['total'] ?? json_encode($value)) : $value);
                $row++;
            }
            $row++;
        };

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
        $sheet->setCellValue('B' . $row, 'Total Pregnant Women');
        $sheet->setCellValue('C' . $row, $data['pregnant']['total'] ?? 'N/A'); $row++;
        $sheet->setCellValue('B' . $row, 'Lactating Mothers');
        $sheet->setCellValue('C' . $row, $data['lactating'] ?? 'N/A'); $row++;
        $row++;

        $writeSection('Household Sanitation', $data['sanitation']);
        $writeSection('Household Water Source', $data['water']);

        // Age & Sex Distribution
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

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    /**
     * Populate Page 2 sheet with barangay data
     */
    private function populatePage2Sheet(Worksheet $sheet, array $data)
    {
        $sheet->setTitle('Barangay Data');
        $row = 1;

        $sheet->setCellValue('A' . $row, 'Summary Data by Barangay')->mergeCells('A' . $row . ':L' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(16);
        $row += 2;

        $writeBarangayTable = function($title, $tableData) use ($sheet, &$row) {
            if (empty($tableData)) return;
            $sheet->setCellValue('A' . $row, $title)->getStyle('A' . $row)->getFont()->setBold(true);
            $row++;

            // Write Headers
            $headers = ['Label'];
            $numBarangays = count($tableData[0]['barangay_data'] ?? []);
            for ($i = 1; $i <= $numBarangays; $i++) {
                $headers[] = 'Barangay ' . $i;
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
                    $rowData = array_merge([$dataRow['label']], $dataRow['barangay_data'], [$dataRow['total']]);
                    $sheet->fromArray($rowData, null, 'A' . $row);
                }
                $row++;
            }
            $row++;
        };

        $writeBarangayTable('Summary', $data['summary']);
        $writeBarangayTable('Age Grouping', $data['age_grouping']);
        
        $sheet->setCellValue('A' . $row, 'Projected Population:')->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('B' . $row, $data['projected_population']);

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    /**
     * Populate Page 3 sheet with age distribution by barangay
     */
    private function populatePage3Sheet(Worksheet $sheet, array $page3)
    {
        $sheet->setTitle('Age Distribution');
        $row = 1;

        // Title
        $sheet->mergeCells("A{$row}:F{$row}");
        $sheet->setCellValue("A{$row}", 'Demographic Data by Age & Barangay');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(14);
        $row++;

        $sheet->mergeCells("A{$row}:F{$row}");
        $sheet->setCellValue("A{$row}", "Ages 1-100");
        $sheet->getStyle("A{$row}")->getFont()->setItalic(true);
        $row++;

        // Headers
        $sheet->setCellValue("A{$row}", "Age");
        $colIndex = 2;
        foreach ($page3['barangays'] as $barangayName) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue("{$colLetter}{$row}", $barangayName);
            $colIndex++;
        }
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue("{$colLetter}{$row}", "Total");
        $headerRow = $row;
        $row++;

        // Data rows
        foreach ($page3['ages'] as $age) {
            $sheet->setCellValue("A{$row}", $age);
            $colIndex = 2;
            $rowTotal = 0;

            foreach ($page3['barangays'] as $barangayName) {
                $male = $page3['malePerBarangay'][$barangayName][$age] ?? 0;
                $female = $page3['femalePerBarangay'][$barangayName][$age] ?? 0;
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

        // Bold header row
        $sheet->getStyle("A{$headerRow}:" . $sheet->getHighestColumn() . $headerRow)
            ->getFont()->setBold(true);

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

}
