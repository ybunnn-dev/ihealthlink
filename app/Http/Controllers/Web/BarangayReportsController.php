<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $hpId = $request->input('program_id');

        if (empty($hpId)) {
            $reportData = $this->returnDemographic($startDate, $endDate);
        }

        return view('midwife.reports', $reportData);
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

        
        $residentFilter = function ($query) use ($startDate, $endDate) {
            $query->where('status', 'active');

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }
        };

        $generalFilter = function ($query) use ($startDate, $endDate) {
            $query->where('status', 'active');

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

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
        ])->orderBy('created_at')->get();
        

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
        $malePerAgePerPurok = [];
        $femalePerAgePerPurok = [];
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

            $wraPerPurok[$purokName] = $residentsCollection
                ->where('sex', 'female')
                ->filter(function($r) {
                    $age = \Carbon\Carbon::parse($r->birthdate)->age;
                    return $age >= 10 && $age <= 49;
                })
                ->count();

            $ageGroupMalePerPurok[$purokName] = [];
            $ageGroupFemalePerPurok[$purokName] = [];

            foreach ($ageGroups as $range) {
                // Handle months or years
                if (str_contains($range, 'months')) {
                    [$min, $max] = explode('-', str_replace(' months', '', $range)) + [0, null];
                    $min = (int)$min;
                    $max = $max !== null ? (int)$max : null;

                    $maleCount = $residentsCollection
                        ->where('sex', 'male')
                        ->filter(function($r) use ($min, $max) {
                            $ageInMonths = \Carbon\Carbon::parse($r->birthdate)->diffInMonths(now());
                            return $max ? ($ageInMonths >= $min && $ageInMonths <= $max) : ($ageInMonths >= $min);
                        })
                        ->count();

                    $femaleCount = $residentsCollection
                        ->where('sex', 'female')
                        ->filter(function($r) use ($min, $max) {
                            $ageInMonths = \Carbon\Carbon::parse($r->birthdate)->diffInMonths(now());
                            return $max ? ($ageInMonths >= $min && $ageInMonths <= $max) : ($ageInMonths >= $min);
                        })
                        ->count();
                } else {
                    [$min, $max] = explode('-', str_replace(' years', '', $range)) + [0, null];
                    $min = (int)$min;
                    $max = $max !== null ? (int)$max : null;

                    $maleCount = $residentsCollection
                        ->where('sex', 'male')
                        ->filter(function($r) use ($min, $max) {
                            $age = \Carbon\Carbon::parse($r->birthdate)->age;
                            return $max ? ($age >= $min && $age <= $max) : ($age >= $min);
                        })
                        ->count();

                    $femaleCount = $residentsCollection
                        ->where('sex', 'female')
                        ->filter(function($r) use ($min, $max) {
                            $age = \Carbon\Carbon::parse($r->birthdate)->age;
                            return $max ? ($age >= $min && $age <= $max) : ($age >= $min);
                        })
                        ->count();
                }

                $ageGroupMalePerPurok[$purokName][] = $maleCount;
                $ageGroupFemalePerPurok[$purokName][] = $femaleCount;
            }
            $malePerAgePerPurok[$purokName] = [];
            $femalePerAgePerPurok[$purokName] = [];

            foreach ($residentsCollection as $resident) {
                if (!$resident->birthdate) continue;
                $age = \Carbon\Carbon::parse($resident->birthdate)->age;

                if ($resident->sex === 'male') {
                    if (!isset($malePerAgePerPurok[$purokName][$age])) {
                        $malePerAgePerPurok[$purokName][$age] = 0;
                    }
                    $malePerAgePerPurok[$purokName][$age]++;
                } else if ($resident->sex === 'female') {
                    if (!isset($femalePerAgePerPurok[$purokName][$age])) {
                        $femalePerAgePerPurok[$purokName][$age] = 0;
                    }
                    $femalePerAgePerPurok[$purokName][$age]++;
                }
            }

            // Optional: sort by age
            ksort($malePerAgePerPurok[$purokName]);
            ksort($femalePerAgePerPurok[$purokName]);
        }

        $residentsCollection = Resident::whereHas('family.household.purok', function ($q) use ($brgyId) {
            $q->where('brgy_id', $brgyId);
        })->where($residentFilter)->get();

        $seniorsTotal = $residentsCollection
            ->filter(function($r) {
                if (!$r->birthdate) return false;
                $age = \Carbon\Carbon::parse($r->birthdate)->age;
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
            ->filter(function($r) {
                if (!$r->birthdate) return false;
                $age = \Carbon\Carbon::parse($r->birthdate)->age;
                return $r->sex === 'female' && $age >= 10 && $age <= 49;
            });

        $wra = $wraTotal->count();
        $maleData = [];
        $femaleData = [];


        foreach ($ageGroups as $range) {
            if (str_contains($range, 'months')) {
                [$min, $max] = explode('-', str_replace(' months', '', $range)) + [0, 0];
                $min = (int)$min;
                $max = (int)$max;

                $maleCount = $residentsCollection->where('sex', 'male')->filter(function($r) use ($min, $max) {
                    $ageMonths = \Carbon\Carbon::parse($r->birthdate)->diffInMonths();
                    return $ageMonths >= $min && $ageMonths <= $max;
                })->count();

                $femaleCount = $residentsCollection->where('sex', 'female')->filter(function($r) use ($min, $max) {
                    $ageMonths = \Carbon\Carbon::parse($r->birthdate)->diffInMonths();
                    return $ageMonths >= $min && $ageMonths <= $max;
                })->count();
            } else {
                $range = str_replace(' years', '', $range);
                if (str_contains($range, '+')) {
                    $min = (int)str_replace('+', '', $range);
                    $max = null;
                } else {
                    [$min, $max] = explode('-', $range) + [0, 0];
                    $min = (int)$min;
                    $max = (int)$max;
                }

                $maleCount = $residentsCollection->where('sex', 'male')->filter(function($r) use ($min, $max) {
                    $age = \Carbon\Carbon::parse($r->birthdate)->age;
                    return $max ? ($age >= $min && $age <= $max) : ($age >= $min);
                })->count();

                $femaleCount = $residentsCollection->where('sex', 'female')->filter(function($r) use ($min, $max) {
                    $age = \Carbon\Carbon::parse($r->birthdate)->age;
                    return $max ? ($age >= $min && $age <= $max) : ($age >= $min);
                })->count();
            }

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