<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Midwife;
use App\Models\Resident;
use App\Models\Household;
use App\Models\HealthProgram;
use App\Models\EnrolledResident;
use App\Models\Family;
use App\Models\Purok;
use App\Models\ResidenceHistory;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $hpId = $request->input('program_id');

        if (empty($hpId)) {
            $reportData = $this->returnDemographic($startDate, $endDate);
        }

        return view('mho.reports', $reportData);
    }


   public function returnDemographic($startDate = null, $endDate = null, $brgyId = null)
    {
        $end = $endDate ? \Carbon\Carbon::parse($endDate) : now();

        /**
         * RESIDENT STATISTICS - Only include residents whose latest history is NOT 'moved'
         */
        $residents = Resident::whereHas('residenceHistories', function ($q) use ($brgyId, $startDate, $endDate) {
            // Filter by barangay if provided
            if ($brgyId) {
                $q->whereHas('purok', function ($q2) use ($brgyId) {
                    $q2->where('brgy_id', $brgyId);
                });
            }
            
            // Date filters
            if ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            }
        })
        ->where('status', 'active')
        ->get()
        ->filter(function($resident) use ($brgyId, $endDate) {
            // Get the latest residence history for this resident
            $latestHistory = $resident->residenceHistories()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->when($brgyId, function($q) use ($brgyId) {
                    $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $brgyId));
                })
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Only include if latest history exists, is not 'moved', and matches barangay (if specified)
            return $latestHistory 
                && $latestHistory->status !== 'moved' 
                && (!$brgyId || ($latestHistory->purok && $latestHistory->purok->brgy_id == $brgyId));
        });

        $totalResidents = $residents->count();

        // Separate by gender for age group calculations
        $maleResidents = $residents->where('sex', 'male');
        $femaleResidents = $residents->where('sex', 'female');

        /**
         * HOUSEHOLD STATISTICS - Only include households whose latest history is NOT 'moved'
         */
        $households = Household::whereHas('householdResidenceHistory', function ($q) use ($brgyId, $startDate, $endDate) {
            if ($brgyId) {
                $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $brgyId));
            }
            
            if ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            }
        })
        ->where('status', 'active')
        ->get()
        ->filter(function($household) use ($brgyId, $endDate) {
            // Get the latest history for this household
            $latestHistory = $household->householdResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->when($brgyId, function($q) use ($brgyId) {
                    $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $brgyId));
                })
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Only include if latest history exists, is not 'moved', and matches barangay (if specified)
            return $latestHistory 
                && $latestHistory->status !== 'moved' 
                && (!$brgyId || ($latestHistory->purok && $latestHistory->purok->brgy_id == $brgyId));
        });

        $householdsCount = $households->count();

        /**
         * FAMILY STATISTICS - Only include families whose latest history is NOT 'moved'
         */
        $families = Family::whereHas('familyResidenceHistory', function ($q) use ($brgyId, $startDate, $endDate) {
            if ($brgyId) {
                $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $brgyId));
            }
            
            if ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            }
        })
        ->where('status', 'active')
        ->get()
        ->filter(function($family) use ($brgyId, $endDate) {
            // Get the latest history for this family
            $latestHistory = $family->familyResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->when($brgyId, function($q) use ($brgyId) {
                    $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $brgyId));
                })
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Only include if latest history exists, is not 'moved', and matches barangay (if specified)
            return $latestHistory 
                && $latestHistory->status !== 'moved' 
                && (!$brgyId || ($latestHistory->purok && $latestHistory->purok->brgy_id == $brgyId));
        });

        $familiesCount = $families->count();

        /**
         * AGE GROUP STATISTICS
         */
        $ageGroups = [
            '0-6 months',
            '6-11 months',
            '1-4 years',
            '5-9 years',
            '10-14 years',
            '15-19 years',
            '20-59 years',
            '60+ years',
        ];
        
        $maleData = [];
        $femaleData = [];
        
        // Process each age group
        foreach ($ageGroups as $range) {
            // Check if this is a months-based range
            if (str_contains($range, 'months')) {
                // Parse months range (e.g., "0-6 months")
                $parts = explode('-', str_replace(' months', '', $range));
                $min = (int)$parts[0];
                $max = isset($parts[1]) ? (int)$parts[1] : $min;

                // Count males in this age range
                $maleCount = $maleResidents->filter(function($resident) use ($min, $max, $end) {
                    $ageInMonths = \Carbon\Carbon::parse($resident->birthdate)->diffInMonths($end);
                    return $ageInMonths >= $min && $ageInMonths <= $max;
                })->count();

                // Count females in this age range
                $femaleCount = $femaleResidents->filter(function($resident) use ($min, $max, $end) {
                    $ageInMonths = \Carbon\Carbon::parse($resident->birthdate)->diffInMonths($end);
                    return $ageInMonths >= $min && $ageInMonths <= $max;
                })->count();

            } else {
                // Parse years range (e.g., "20-59 years", "60+ years")
                $range = str_replace(' years', '', $range);
                
                if (str_contains($range, '+')) {
                    // Handle open-ended range (e.g., "60+")
                    $min = (int)str_replace('+', '', $range);
                    $max = null;
                } else {
                    // Handle standard range (e.g., "20-59")
                    $parts = explode('-', $range);
                    $min = (int)$parts[0];
                    $max = isset($parts[1]) ? (int)$parts[1] : $min;
                }

                // Count males in this age range
                $maleCount = $maleResidents->filter(function($resident) use ($min, $max, $end) {
                    $ageInYears = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);
                    return $max ? ($ageInYears >= $min && $ageInYears <= $max) : ($ageInYears >= $min);
                })->count();

                // Count females in this age range
                $femaleCount = $femaleResidents->filter(function($resident) use ($min, $max, $end) {
                    $ageInYears = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);
                    return $max ? ($ageInYears >= $min && $ageInYears <= $max) : ($ageInYears >= $min);
                })->count();
            }

            // Store counts for this age group
            $maleData[] = $maleCount;
            $femaleData[] = $femaleCount;
        }

        $data = [
            'residents' => $totalResidents,
            'families' => $familiesCount,
            'households' => $householdsCount,

            'ageGroups' => $ageGroups,
            'maleData' => $maleData,
            'femaleData' => $femaleData,
        ];

        return $data;
    }
}
