<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Midwife;
use App\Models\Resident;
use App\Models\Household;
use App\Models\Family;
use App\Models\Purok;
use App\Models\ResidenceHistory;

class BarangayReportsController extends Controller
{   
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $hpId = $request->input('program_id');

        if (empty($hpId)) {
            $reportData = $this->returnDemographic($startDate, $endDate);
        }

        return view('midwife.reports', $reportData);
    }
    
    public function returnDemographic($startDate = null, $endDate = null, $brgyId = null)
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

        $generalFilter = function ($query) use ($startDate, $endDate) {
            $query->where('status', 'active');

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }
        };

        $end = $endDate ? \Carbon\Carbon::parse($endDate) : now();

        /**
         * RESIDENT STATISTICS
         */
        $residenceHistories = ResidenceHistory::with('resident') // eager load the related resident
            ->whereHas('purok', function ($q) use ($brgyId) {
                $q->where('brgy_id', $brgyId); // filter by barangay via purok
            })
            ->where('status', 'active'); // only active residence histories

        if ($startDate) {
            $residenceHistories->whereDate('updated_at', '>=', $startDate); // still active after start
        }

        if ($endDate) {
            $residenceHistories->whereDate('created_at', '<=', $endDate); // existed before end
        }

        $residenceHistories = $residenceHistories->get();

        // Get the residents from these histories
        $residents = $residenceHistories->pluck('resident')->unique('id');

        $totalResidents = $residents->count();

        $households = Household::whereHas('purok', function ($q) use ($brgyId) {
            $q->where('brgy_id', $brgyId);
        })->where($generalFilter)->count();

        $households4sanitary = Household::whereHas('purok', function ($q) use ($brgyId) {
            $q->where('brgy_id', $brgyId);
        })->where($generalFilter)->get(); // <-- get() returns a collection

        $families = Family::whereHas('household.purok', function ($q) use ($brgyId) {
            $q->where('brgy_id', $brgyId);
        })->where($generalFilter)->count();

        $puroks = Purok::where('brgy_id', $brgyId)
            ->with([
                'households' => function ($h) use ($generalFilter, $startDate, $endDate, $brgyId) {
                    $h->where($generalFilter)
                    ->with([
                        'families' => function ($f) use ($generalFilter, $startDate, $endDate, $brgyId) {
                            $f->where($generalFilter)
                                ->with(['residents' => function ($r) use ($startDate, $endDate, $brgyId) {
                                    // Filter residents by their residence histories
                                    $r->whereHas('residenceHistory', function ($q) use ($startDate, $endDate, $brgyId) {
                                        $q->whereHas('purok', function ($q2) use ($brgyId) {
                                            $q2->where('brgy_id', $brgyId);
                                        })
                                        ->where('status', 'active');

                                        if ($startDate) {
                                            $q->whereDate('updated_at', '>=', $startDate);
                                        }

                                        if ($endDate) {
                                            $q->whereDate('created_at', '<=', $endDate);
                                        }
                                    });
                                }]);
                        }
                    ]);
                }
            ])->orderBy('created_at')
            ->get();

        $ageGroups = [
            '0-6 months',
            '6-11 months',
            '1-4 years',      // 12-59 months
            '5-9 years',      // 60-119 months
            '10-14 years',
            '15-19 years',
            '20-59 years',
            '60+ years',
        ];


        $householdsPerPurok = [];
        $familiesPerPurok = [];
        $families4PsPerPurok = [];
        $familiesIndigentPerPurok = [];

        foreach ($puroks as $purok) {
            $purokName = $purok->name;

            // Count households in this purok
            $householdsPerPurok[$purokName] = $purok->households->count();

            // Collect and count families in this purok
            $familiesCollection = $purok->households->flatMap->families;
            $familiesPerPurok[$purokName] = $familiesCollection->count();
            $families4PsPerPurok[$purokName] = $familiesCollection->where('is_4ps', true)->count();
            $familiesIndigentPerPurok[$purokName] = $familiesCollection->where('is_indigent', true)->count();
        }

        $residentsPerPurok = [];
        $malesPerPurok = [];
        $femalesPerPurok = [];
        $pwdsPerPurok = [];
        $nonPwdsPerPurok = [];
        $malePwdsPerPurok = [];
        $femalePwdsPerPurok = [];
        $wraPerPurok = [];
        $ageGroupMalePerPurok = [];
        $ageGroupFemalePerPurok = [];
        $malePerAgePerPurok = [];
        $femalePerAgePerPurok = [];

foreach ($puroks as $purok) {
    $purokName = $purok->name;
    $purokId = $purok->id;

    // Collect active residents for this purok based on their purok_id and residence history
    $residentsCollection = Resident::where('purok_id', $purokId)
        ->whereHas('residenceHistory', function($query) use ($startDate, $endDate, $brgyId) {
            $query->whereHas('purok', fn($q) => $q->where('brgy_id', $brgyId))
                ->where('status', 'active')
                ->when($startDate, fn($q) => $q->whereDate('updated_at', '>=', $startDate))
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate));
        })
        ->get();

    // Count total residents
    $residentsPerPurok[$purokName] = $residentsCollection->count();

    // Pre-filter residents by sex for efficiency
    $maleResidents = $residentsCollection->where('sex', 'male');
    $femaleResidents = $residentsCollection->where('sex', 'female');

    // Count by sex
    $malesPerPurok[$purokName] = $maleResidents->count();
    $femalesPerPurok[$purokName] = $femaleResidents->count();

    // Count PWDs
    $pwdsPerPurok[$purokName] = $residentsCollection->where('is_pwd', true)->count();
    $nonPwdsPerPurok[$purokName] = $residentsCollection->where('is_pwd', false)->count();
    $malePwdsPerPurok[$purokName] = $maleResidents->where('is_pwd', true)->count();
    $femalePwdsPerPurok[$purokName] = $femaleResidents->where('is_pwd', true)->count();

    // Count WRA (Women of Reproductive Age: 10-49 years old)
    $wraPerPurok[$purokName] = $femaleResidents->filter(function($resident) use ($end) {
        if (!$resident->birthdate) return false;
        $age = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);
        return $age >= 10 && $age <= 49;
    })->count();

    // Initialize age group arrays for this purok
    $ageGroupMalePerPurok[$purokName] = [];
    $ageGroupFemalePerPurok[$purokName] = [];
    $malePerAgePerPurok[$purokName] = [];
    $femalePerAgePerPurok[$purokName] = [];

    // Process each age group
    foreach ($ageGroups as $range) {
        if (str_contains($range, 'months')) {
            // Parse months range (e.g., "0-11 months" or "0+ months")
            $parsedRange = str_replace(' months', '', $range);
            [$min, $max] = explode('-', $parsedRange) + [0, null];
            $min = (int)$min;
            $max = $max !== null ? (int)$max : null;

            // Count males in this months-based age range
            $maleCount = $maleResidents->filter(function($resident) use ($min, $max, $end) {
                if (!$resident->birthdate) return false;
                $ageInMonths = \Carbon\Carbon::parse($resident->birthdate)->diffInMonths($end);
                return $max ? ($ageInMonths >= $min && $ageInMonths <= $max) : ($ageInMonths >= $min);
            })->count();

            // Count females in this months-based age range
            $femaleCount = $femaleResidents->filter(function($resident) use ($min, $max, $end) {
                if (!$resident->birthdate) return false;
                $ageInMonths = \Carbon\Carbon::parse($resident->birthdate)->diffInMonths($end);
                return $max ? ($ageInMonths >= $min && $ageInMonths <= $max) : ($ageInMonths >= $min);
            })->count();

        } else {
            // Parse years range (e.g., "18-24 years" or "65+ years")
            $parsedRange = str_replace(' years', '', $range);
            [$min, $max] = explode('-', $parsedRange) + [0, null];
            $min = (int)$min;
            $max = $max !== null ? (int)$max : null;

            // Count males in this years-based age range
            $maleCount = $maleResidents->filter(function($resident) use ($min, $max, $end) {
                if (!$resident->birthdate) return false;
                $ageInYears = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);
                return $max ? ($ageInYears >= $min && $ageInYears <= $max) : ($ageInYears >= $min);
            })->count();

            // Count females in this years-based age range
            $femaleCount = $femaleResidents->filter(function($resident) use ($min, $max, $end) {
                if (!$resident->birthdate) return false;
                $ageInYears = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);
                return $max ? ($ageInYears >= $min && $ageInYears <= $max) : ($ageInYears >= $min);
            })->count();
        }

        // Store counts for this age group
        $ageGroupMalePerPurok[$purokName][] = $maleCount;
        $ageGroupFemalePerPurok[$purokName][] = $femaleCount;
    }

    // Count residents by exact age (in years)
    foreach ($residentsCollection as $resident) {
        if (!$resident->birthdate) continue;
        
        $age = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);

        if ($resident->sex === 'male') {
            $malePerAgePerPurok[$purokName][$age] = ($malePerAgePerPurok[$purokName][$age] ?? 0) + 1;
        } elseif ($resident->sex === 'female') {
            $femalePerAgePerPurok[$purokName][$age] = ($femalePerAgePerPurok[$purokName][$age] ?? 0) + 1;
        }
    }

    // Sort age arrays by age (ascending)
    ksort($malePerAgePerPurok[$purokName]);
    ksort($femalePerAgePerPurok[$purokName]);
}

       $residentsCollection = ResidenceHistory::with('resident') // eager load the related resident
            ->whereHas('purok', function ($q) use ($brgyId) {
                $q->where('brgy_id', $brgyId); // filter by purok's barangay
            })
            ->where('status', 'active'); // only active histories

        if ($startDate) {
            $residentsCollection->whereDate('updated_at', '>=', $startDate);
        }

        if ($endDate) {
            $residentsCollection->whereDate('created_at', '<=', $endDate);
        }

        $residentsCollection = $residentsCollection->get()
            ->pluck('resident') // get the actual resident models
            ->unique('id');     // avoid duplicates

        $seniorsTotal = $residentsCollection
            ->filter(function($r) use ($end) {
                if (!$r->birthdate) return false;
                $age = \Carbon\Carbon::parse($r->birthdate)->diffInYears($end);
                return $age >= 60;
        });

        $seniorsMale = $seniorsTotal->where('sex', 'male')->count();
        $seniorsFemale = $seniorsTotal->where('sex', 'female')->count();
        $seniors = [
            'total' => $seniorsTotal->count(),
            'male' => $seniorsMale,
            'female' => $seniorsFemale,
        ];

        $wraTotal = $residentsCollection
            ->filter(function($r) use ($end) {
                if (!$r->birthdate) return false;
                $age = \Carbon\Carbon::parse($r->birthdate)->diffInYears($end);
                return $r->sex === 'female' && $age >= 10 && $age <= 49;
            });
        
        $wra = $wraTotal->count();
        $maleData = [];
        $femaleData = [];

        $maleResidents = $residentsCollection->where('sex', 'male');
        $femaleResidents = $residentsCollection->where('sex', 'female');

        // Process each age group
        foreach ($ageGroups as $range) {
            // Check if this is a months-based range
            if (str_contains($range, 'months')) {
                // Parse months range (e.g., "0-11 months")
                [$min, $max] = explode('-', str_replace(' months', '', $range)) + [0, 0];
                $min = (int)$min;
                $max = (int)$max;

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
                // Parse years range (e.g., "18-24 years", "65+ years")
                $range = str_replace(' years', '', $range);
                
                if (str_contains($range, '+')) {
                    // Handle open-ended range (e.g., "65+")
                    $min = (int)str_replace('+', '', $range);
                    $max = null;
                } else {
                    // Handle standard range (e.g., "18-24")
                    [$min, $max] = explode('-', $range) + [0, 0];
                    $min = (int)$min;
                    $max = (int)$max;
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
        $wasteDisposalData = $households4sanitary->groupBy('waste_disposal')->map->count()->toArray();
        $waterSourceData = $households4sanitary->groupBy('water_source')->map->count()->toArray();
        
        $sanitaryData = [
            'with_sanitary_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'with_sanitary_toilet')->count(),
            'with_unsanitary_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'with_unsanitary_toilet')->count(),
            'without_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'without_toilet')->count(),
        ];

        $puroks = Purok::where('brgy_id', $brgyId)->orderBy('created_at')->pluck('name')->toArray();

        $data = [
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
            'sanitaryData' => $sanitaryData,

            'ageGroupMalePerPurok' => $ageGroupMalePerPurok,
            'ageGroupFemalePerPurok' => $ageGroupFemalePerPurok,

            'wraPerPurok' => $wraPerPurok,
            'wra' => $wra,
            'seniors' => $seniors,
            'puroks' => $puroks,
            'maleAgePerPurok' => $malePerAgePerPurok,
            'femaleAgePerPurok' => $femalePerAgePerPurok,
            'programId' => null
        ];

        return $data;
    }
}