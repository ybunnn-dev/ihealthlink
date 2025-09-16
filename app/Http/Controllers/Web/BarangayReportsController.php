<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class BarangayReportsController extends Controller
{
public function generateCommunityReport()
    {
        // All data is prepared here, matching the structure in your Blade file.
        $data = [
            'page1' => [
                'population' => ['total' => 7376, 'male' => 3676, 'female' => 3700],
                'households' => ['total' => 1841, 'indigent' => 300, 'non_indigent' => 1541],
                'families' => 2188,
                'four_ps' => 114,
                'seniors' => ['total' => 1025, 'male' => 456, 'female' => 569],
                'pwd' => ['total' => 174, 'male' => 73, 'female' => 101],
                'wra' => 1978,
                'pregnant' => ['total' => null], // Use null or fetch real data
                'lactating' => null,             // Use null or fetch real data
                'age_sex_distribution' => [
                    ['group' => '70 & up', 'male' => 175, 'female' => 255],
                    ['group' => '65-69', 'male' => 124, 'female' => 141],
                    ['group' => '60-64', 'male' => 157, 'female' => 173],
                    ['group' => '55-59', 'male' => 181, 'female' => 201],
                    ['group' => '50-54', 'male' => 21, 'female' => 224],
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
                'sanitation' => ['with_sanitary' => 1818, 'with_unsanitary' => 2, 'without' => 21],
                'water' => ['pumpwell' => 113, 'open_well' => 3, 'purified' => 1841, 'tap' => 1725],
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

        // Load the combined view and pass the data to it.
        $pdf = Pdf::loadView('reports.combined_community_report', ['data' => $data]);
        
        // Set paper size to Legal to better fit the wide table on the second page.
        // You can use 'A4' and 'landscape' as well. 'legal' is taller than A4.
        $pdf->setPaper('Legal', 'portrait');

        // Return the PDF to the browser to be displayed.
        return $pdf->stream('Barangay-Tagas-Report-2025.pdf');
    }
}
