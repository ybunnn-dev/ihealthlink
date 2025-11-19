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

       

        $end = $endDate ? \Carbon\Carbon::parse($endDate) : now();

        /**
         * RESIDENT STATISTICS
         */
        $residenceHistories = ResidenceHistory::with('resident')
            ->whereHas('purok', function ($q) use ($brgyId) {
                $q->where('brgy_id', $brgyId);
            })
            ->when($startDate, function ($q) use ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($end) {
                $q->whereDate('created_at', '<=', $end);
            })
            ->get()
            ->groupBy('resident_id')
            ->map(function ($histories) use ($end) {
                // Get the history closest to (but not after) the end date
                return $histories->sortByDesc('created_at')->first();
            });

        $residents = $residenceHistories->pluck('resident')->unique('id');
        $totalResidents = $residents->count();

        $households = Household::whereHas('householdResidenceHistory', function ($q) use ($brgyId, $startDate, $endDate) {
            $q->whereHas('purok', function ($q2) use ($brgyId) {
                $q2->where('brgy_id', $brgyId);
            });
            
            if ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            }
            if ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            }
        })
        ->get()
        ->filter(function($household) use ($brgyId, $endDate) {
            // Get the latest history for this household up to the end date
            $latestHistory = $household->householdResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Only include if latest history is in this barangay
            return $latestHistory && $latestHistory->purok && $latestHistory->purok->brgy_id == $brgyId;
        })
        ->count();

        $households4sanitary = Household::whereHas('householdResidenceHistory', function ($q) use ($brgyId, $startDate, $endDate) {
            $q->whereHas('purok', function ($q2) use ($brgyId) {
                $q2->where('brgy_id', $brgyId);
            });
            
            if ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            }
            if ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            }
        })
        ->get()
        ->filter(function($household) use ($brgyId, $endDate) {
            $latestHistory = $household->householdResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            return $latestHistory && $latestHistory->purok && $latestHistory->purok->brgy_id == $brgyId;
        })
        ->map(function($household) use ($endDate) {
            // Get the latest history and attach its data to the household
            $latestHistory = $household->householdResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Attach the sanitary data from the latest history
            $household->water_source = $latestHistory->water_source ?? null;
            $household->waste_disposal = $latestHistory->waste_disposal ?? null;
            $household->sanitary_toilet = $latestHistory->sanitary_toilet ?? null;
            
            return $household;
        });


      $families = Family::whereHas('familyResidenceHistory', function ($q) use ($brgyId, $startDate, $endDate) {
            $q->whereHas('purok', function ($q2) use ($brgyId) {
                $q2->where('brgy_id', $brgyId);
            });
            
            if ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            }
            if ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            }
        })
        ->get()
        ->filter(function($family) use ($brgyId, $endDate) {
            // Get the latest history for this family up to the end date
            $latestHistory = $family->familyResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Only include if latest history is in this barangay
            return $latestHistory && $latestHistory->purok && $latestHistory->purok->brgy_id == $brgyId;
        })
        ->count();

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
        
        
        $puroks = Purok::where('brgy_id', $brgyId)
        ->orderBy('created_at')
        ->get();
      
        $householdsPerPurok = [];
        $familiesPerPurok = [];
        $families4PsPerPurok = [];
        $familiesIndigentPerPurok = [];

        foreach ($puroks as $purok) {
            $purokName = $purok->name;
            $purokId = $purok->id;
            
            // Get households with latest history in this purok
            $householdsInPurok = Household::whereHas('householdResidenceHistory', function($query) use ($purokId, $startDate, $endDate) {
                $query->where('purok_id', $purokId);
                if ($endDate) $query->whereDate('created_at', '<=', $endDate);
                if ($startDate) $query->whereDate('created_at', '>=', $startDate);
            })
            ->get()
            ->filter(function($household) use ($purokId, $endDate) {
                $latestHistory = $household->householdResidenceHistory()
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->orderBy('created_at', 'desc')
                    ->first();
                return $latestHistory && $latestHistory->purok_id == $purokId;
            });
            
            $householdsPerPurok[$purokName] = $householdsInPurok->count();
            
            // Get families with latest history in this purok
            $familiesInPurok = Family::whereHas('familyResidenceHistory', function($query) use ($purokId, $startDate, $endDate) {
                $query->where('purok_id', $purokId);
                if ($endDate) $query->whereDate('created_at', '<=', $endDate);
                if ($startDate) $query->whereDate('created_at', '>=', $startDate);
            })
            ->get()
            ->filter(function($family) use ($purokId, $endDate) {
                $latestHistory = $family->familyResidenceHistory()
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->orderBy('created_at', 'desc')
                    ->first();
                return $latestHistory && $latestHistory->purok_id == $purokId;
            })
            ->map(function($family) use ($endDate) {
                $latestHistory = $family->familyResidenceHistory()
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->orderBy('created_at', 'desc')
                    ->first();
                $family->is_4ps = $latestHistory->is_4ps ?? false;
                $family->is_indigent = $latestHistory->is_indigent ?? false;
                return $family;
            });
            
            $familiesPerPurok[$purokName] = $familiesInPurok->count();
            $families4PsPerPurok[$purokName] = $familiesInPurok->where('is_4ps', true)->count();
            $familiesIndigentPerPurok[$purokName] = $familiesInPurok->where('is_indigent', true)->count();
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
        $pregnantPerPurok = [];      // ADD THIS
        $lactatingPerPurok = [];      // ADD THIS

    foreach ($puroks as $purok) {
        $purokName = $purok->name;
        $purokId = $purok->id;

        $residentsCollection = Resident::whereHas('residenceHistory', function($query) use ($purokId, $startDate, $endDate) {
            $query->where('purok_id', $purokId);
            
            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }
            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }
        })
        ->get()
        ->filter(function($resident) use ($purokId, $endDate) {
            // For each resident, get their latest residence history up to the end date
            $latestHistory = $resident->residenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Only include this resident if their latest history is in this purok
            return $latestHistory && $latestHistory->purok_id == $purokId;
        });

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

        // ADD THIS: Count pregnant women in this purok
        $pregnantPerPurok[$purokName] = $femaleResidents->filter(function($resident) use ($endDate) {
            // Get the latest consultation for this resident up to the end date
            $latestConsultation = $resident->consultations()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Check if they are pregnant based on latest consultation
            return $latestConsultation && $latestConsultation->is_pregnant == true;
        })->count();

        // ADD THIS: Count lactating mothers in this purok
        $lactatingPerPurok[$purokName] = $femaleResidents->filter(function($resident) use ($endDate) {
            // Get the latest consultation for this resident up to the end date
            $latestConsultation = $resident->consultations()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Check if they are lactating based on latest consultation
            return $latestConsultation && $latestConsultation->is_lactating == true;
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
            });

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

        $puroks = Purok::where('brgy_id', $brgyId)
            ->orderBy('created_at')
            ->get()
            ->map(fn($p) => $p->name)
            ->toArray();
        
        
        // Get the maternal health program
        $maternalHealthProgram = HealthProgram::where('category', 'maternal_health_tcl')->first();

        $pregnantWomen = 0;
        $teenPregnancies = 0;
        $totalLactating = 0;

        // NEW: Pregnancy type breakdown
        $primis = 0;      // First pregnancy (para = 0)
        $multiPara = 0;   // Multiple pregnancies (para >= 2)
        $others = 0;      // Other cases

        if ($maternalHealthProgram) {
            // Get enrolled residents in maternal health program from filtered residents
            $enrolledInMaternal = EnrolledResident::where('program_id', $maternalHealthProgram->id)
                ->whereIn('resident_id', $residents->pluck('id'))
                ->with(['resident', 'maternalRecord'])
                ->get()
                ->filter(function($enrollment) use ($endDate) {
                    // Get the enrollment date closest to end date
                    if ($endDate) {
                        return \Carbon\Carbon::parse($enrollment->created_at)->lte(\Carbon\Carbon::parse($endDate));
                    }
                    return true;
                })
                ->groupBy('resident_id')
                ->map(function($enrollments) use ($endDate) {
                    // Get the latest enrollment for this resident up to the end date
                    return $enrollments->sortByDesc('created_at')->first();
                });

            $pregnantWomen = $enrolledInMaternal->count();

            // Count teen pregnancies (age <= 19 at time of enrollment)
            $teenPregnancies = $enrolledInMaternal->filter(function($enrollment) {
                if (!$enrollment->resident || !$enrollment->resident->birthdate) {
                    return false;
                }
                
                // Calculate age at enrollment
                $enrollmentDate = \Carbon\Carbon::parse($enrollment->created_at);
                $birthdate = \Carbon\Carbon::parse($enrollment->resident->birthdate);
                $ageAtEnrollment = $birthdate->diffInYears($enrollmentDate);
                
                return $ageAtEnrollment <= 19;
            })->count();
            
            // NEW: Calculate pregnancy type breakdown
            foreach ($enrolledInMaternal as $enrollment) {
                $maternalRecord = $enrollment->maternalRecord;
                
                if ($maternalRecord && isset($maternalRecord->para)) {
                    $para = $maternalRecord->para;
                    
                    if ($para == 0) {
                        // First pregnancy (Primis/Primigravida)
                        $primis++;
                    } elseif ($para >= 2) {
                        // Multiple pregnancies (Multipara)
                        $multiPara++;
                    } else {
                        // Other cases (para = 1 or null/invalid)
                        $others++;
                    }
                } else {
                    // No maternal record or para data
                    $others++;
                }
            }
        }
        $totalLactating = $residents->filter(function($resident) use ($endDate) {
            // Get the latest consultation for this resident up to the end date
            $latestConsultation = $resident->consultations()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Check if they are lactating based on latest consultation
            return $latestConsultation && $latestConsultation->is_lactating == true;
        })->count();


        $familyPlanningProgram = HealthProgram::where('category', 'family_planning_tcl')->first();

        $familyPlanningMethods = [];
        $totalFamilyPlanningEnrollees = 0;

        if ($familyPlanningProgram) {
            // Get enrolled residents in family planning program from filtered residents
            $enrolledInFP = EnrolledResident::where('program_id', $familyPlanningProgram->id)
                ->whereIn('resident_id', $residents->pluck('id'))
                ->with(['resident', 'familyPlanningData'])
                ->get()
                ->filter(function($enrollment) use ($endDate) {
                    // Get enrollments created before or on the end date
                    if ($endDate) {
                        return \Carbon\Carbon::parse($enrollment->created_at)->lte(\Carbon\Carbon::parse($endDate));
                    }
                    return true;
                })
                ->groupBy('resident_id')
                ->map(function($enrollments) use ($endDate) {
                    // Get the latest enrollment for this resident up to the end date
                    return $enrollments->sortByDesc('created_at')->first();
                });

            $totalFamilyPlanningEnrollees = $enrolledInFP->count();

            // Extract family planning data and group by previous_method
            $familyPlanningMethods = $enrolledInFP
                ->map(function($enrollment) {
                    return $enrollment->familyPlanningData;
                })
                ->filter() // Remove null values (enrollments without family planning data)
                ->groupBy('previous_method')
                ->map(function($group) {
                    return $group->count();
                })
                ->toArray();
        }

        // Get the child healthcare program
        $childHealthcareProgram = HealthProgram::where('category', 'child_healthcare_tcl')->first();

        $totalChildrenEnrolled = 0;
        $ficCount = 0;
        $cicCount = 0;
        $childrenWithWeightHeight = 0;

        // NEW: Nutritional status classification
        $normalWeight = 0;
        $underweight = 0;
        $severelyUnderweight = 0;
        $overweight = 0;
        $obese = 0;

        if ($childHealthcareProgram) {
            // Get enrolled residents in child healthcare program from filtered residents
            $enrolledInChildHealth = EnrolledResident::where('program_id', $childHealthcareProgram->id)
                ->whereIn('resident_id', $residents->pluck('id'))
                ->with(['resident', 'childHealthcare'])
                ->get()
                ->filter(function($enrollment) use ($endDate) {
                    if ($endDate) {
                        return \Carbon\Carbon::parse($enrollment->created_at)->lte(\Carbon\Carbon::parse($endDate));
                    }
                    return true;
                })
                ->groupBy('resident_id')
                ->map(function($enrollments) use ($endDate) {
                    return $enrollments->sortByDesc('created_at')->first();
                });

            $totalChildrenEnrolled = $enrolledInChildHealth->count();

            // Process each enrolled child
            foreach ($enrolledInChildHealth as $enrollment) {
                $childHealthData = $enrollment->childHealthcare;

                if ($childHealthData) {
                    $hasFic = !empty($childHealthData->fic_date);
                    $hasCic = !empty($childHealthData->cic_date);

                    if ($hasCic) {
                        $cicCount++;
                    } elseif ($hasFic) {
                        $ficCount++;
                    }
                }

                // Get latest consultation with weight and height
                $latestConsultation = $enrollment->consultations()
                    ->with('consultationData')
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->whereHas('consultationData', function($q) {
                        $q->whereNotNull('weight')
                        ->whereNotNull('height');
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($latestConsultation && $latestConsultation->consultationData) {
                    $childrenWithWeightHeight++;
                    
                    // Calculate nutritional status for children under 2 years
                    $resident = $enrollment->resident;
                    if ($resident && $resident->birthdate) {
                        $ageInMonths = \Carbon\Carbon::parse($resident->birthdate)->diffInMonths($endDate ?? now());
                        
                        // Only classify children 0-23 months (under 2 years)
                        if ($ageInMonths <= 23) {
                            $weight = $latestConsultation->consultationData->weight; // in kg
                            $height = $latestConsultation->consultationData->height; // in cm
                            
                            // Calculate BMI (Weight in kg / (Height in meters)^2)
                            $heightInMeters = $height / 100;
                            $bmi = $weight / ($heightInMeters * $heightInMeters);
                            
                            // Classify based on WHO BMI-for-age standards for children 0-2 years
                            // These are approximate thresholds - adjust based on your health standards
                            if ($bmi < 13.0) {
                                $severelyUnderweight++;
                            } elseif ($bmi < 14.5) {
                                $underweight++;
                            } elseif ($bmi <= 17.5) {
                                $normalWeight++;
                            } elseif ($bmi <= 19.0) {
                                $overweight++;
                            } else {
                                $obese++;
                            }
                        }
                    }
                }
            }
        }
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
            'programId' => null,
            'pregnantPerPurok' => $pregnantPerPurok,      // ADD THIS
            'lactatingPerPurok' => $lactatingPerPurok,    // ADD THIS

            'pregnantWomen' => $pregnantWomen,           // ADD THIS
            'teenPregnancies' => $teenPregnancies,       // ADD THIS
            'totalLactating' => $totalLactating,         // ADD THIS
            'primis' => $primis,              // ADD THIS
            'multiPara' => $multiPara,        // ADD THIS
            'pregnancyOthers' => $others,     // ADD THIS

            'familyPlanningMethods' => $familyPlanningMethods,           // ADD THIS
            'totalFamilyPlanningEnrollees' => $totalFamilyPlanningEnrollees,  // ADD THIS

            'totalChildrenEnrolled' => $totalChildrenEnrolled,      // ADD THIS
            'ficCount' => $ficCount,                                // ADD THIS
            'cicCount' => $cicCount,                                // ADD THIS
            'childrenWithWeightHeight' => $childrenWithWeightHeight, // ADD THIS

            'normalWeight' => $normalWeight,
            'underweight' => $underweight,
            'severelyUnderweight' => $severelyUnderweight,
            'overweight' => $overweight,
            'obese' => $obese,
        ];

        return $data;
    }
}