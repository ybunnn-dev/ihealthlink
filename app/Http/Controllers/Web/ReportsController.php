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
use App\Models\Barangay;

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
         * RESIDENT STATISTICS - Exclude if latest history is 'moved'/'deceased' within date range
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
        ->filter(function($resident) use ($brgyId, $endDate, $startDate) {
            // Get the latest residence history for this resident
            $latestHistory = $resident->residenceHistories()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->when($brgyId, function($q) use ($brgyId) {
                    $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $brgyId));
                })
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$latestHistory) {
                return false;
            }

            // Check if barangay matches (if specified)
            if ($brgyId && (!$latestHistory->purok || $latestHistory->purok->brgy_id != $brgyId)) {
                return false;
            }

            // If status is 'moved' or 'deceased', check if updated_at falls within range
            if (in_array($latestHistory->status, ['moved', 'deceased'])) {
                $updatedAt = \Carbon\Carbon::parse($latestHistory->updated_at);
                
                // Exclude if updated_at is within the date range
                if ($startDate && $updatedAt >= \Carbon\Carbon::parse($startDate)) {
                    return false;
                }
                if ($endDate && $updatedAt <= \Carbon\Carbon::parse($endDate)) {
                    return false;
                }
            }
            
            return true;
        });

        $totalResidents = $residents->count();

        // Separate by gender for age group calculations
        $maleResidents = $residents->where('sex', 'male');
        $femaleResidents = $residents->where('sex', 'female');

        /**
         * HOUSEHOLD STATISTICS - Exclude if latest history is 'moved'/'inactive' within date range
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
        ->filter(function($household) use ($brgyId, $endDate, $startDate) {
            // Get the latest history for this household
            $latestHistory = $household->householdResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->when($brgyId, function($q) use ($brgyId) {
                    $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $brgyId));
                })
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$latestHistory) {
                return false;
            }

            // Check if barangay matches (if specified)
            if ($brgyId && (!$latestHistory->purok || $latestHistory->purok->brgy_id != $brgyId)) {
                return false;
            }

            // If status is 'moved' or 'inactive', check if updated_at falls within range
            if (in_array($latestHistory->status, ['moved', 'inactive'])) {
                $updatedAt = \Carbon\Carbon::parse($latestHistory->updated_at);
                
                // Exclude if updated_at is within the date range
                if ($startDate && $updatedAt >= \Carbon\Carbon::parse($startDate)) {
                    return false;
                }
                if ($endDate && $updatedAt <= \Carbon\Carbon::parse($endDate)) {
                    return false;
                }
            }
            
            return true;
        });

        $householdsCount = $households->count();

        /**
         * FAMILY STATISTICS - Exclude if latest history is 'moved'/'inactive' within date range
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
        ->filter(function($family) use ($brgyId, $endDate, $startDate) {
            // Get the latest history for this family
            $latestHistory = $family->familyResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->when($brgyId, function($q) use ($brgyId) {
                    $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $brgyId));
                })
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$latestHistory) {
                return false;
            }

            // Check if barangay matches (if specified)
            if ($brgyId && (!$latestHistory->purok || $latestHistory->purok->brgy_id != $brgyId)) {
                return false;
            }

            // If status is 'moved' or 'inactive', check if updated_at falls within range
            if (in_array($latestHistory->status, ['moved', 'inactive'])) {
                $updatedAt = \Carbon\Carbon::parse($latestHistory->updated_at);
                
                // Exclude if updated_at is within the date range
                if ($startDate && $updatedAt >= \Carbon\Carbon::parse($startDate)) {
                    return false;
                }
                if ($endDate && $updatedAt <= \Carbon\Carbon::parse($endDate)) {
                    return false;
                }
            }
            
            return true;
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

        /**
         * PER BARANGAY STATISTICS
         */
        $barangays = Barangay::where('status', 'active')
            ->orderBy('created_at')
            ->get();

        $householdsPerBarangay = [];
        $familiesPerBarangay = [];
        $families4PsPerBarangay = [];
        $familiesIndigentPerBarangay = [];

        foreach ($barangays as $barangay) {
            /**
             * HOUSEHOLDS PER BARANGAY - Based on latest residence history
             */
            $householdsInBarangay = Household::where('status', 'active')
                ->whereHas('householdResidenceHistory', function ($q) use ($barangay) {
                    $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $barangay->id));
                })
                ->get()
                ->filter(function($household) use ($barangay, $endDate, $startDate) {
                    // Get the latest history up to endDate
                    $latestHistory = $household->householdResidenceHistory()
                        ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    if (!$latestHistory || !$latestHistory->purok || $latestHistory->purok->brgy_id != $barangay->id) {
                        return false;
                    }

                    // If status is 'moved' or 'inactive', check if updated_at falls within range
                    if (in_array($latestHistory->status, ['moved', 'inactive'])) {
                        $updatedAt = \Carbon\Carbon::parse($latestHistory->updated_at);
                        
                        // Exclude if updated_at is within the date range
                        if ($startDate && $updatedAt >= \Carbon\Carbon::parse($startDate)) {
                            return false;
                        }
                        if ($endDate && $updatedAt <= \Carbon\Carbon::parse($endDate)) {
                            return false;
                        }
                    }
                    
                    return true;
                })
                ->count();
            
            $householdsPerBarangay[] = $householdsInBarangay;

            /**
             * FAMILIES PER BARANGAY - Based on latest residence history
             */
            $allFamilies = Family::where('status', 'active')
                ->whereHas('familyResidenceHistory', function ($q) use ($barangay) {
                    $q->whereHas('purok', fn($q2) => $q2->where('brgy_id', $barangay->id));
                })
                ->get()
                ->filter(function($family) use ($barangay, $endDate, $startDate) {
                    // Get the latest history up to endDate
                    $latestHistory = $family->familyResidenceHistory()
                        ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    if (!$latestHistory || !$latestHistory->purok || $latestHistory->purok->brgy_id != $barangay->id) {
                        return false;
                    }

                    // If status is 'moved' or 'inactive', check if updated_at falls within range
                    if (in_array($latestHistory->status, ['moved', 'inactive'])) {
                        $updatedAt = \Carbon\Carbon::parse($latestHistory->updated_at);
                        
                        // Exclude if updated_at is within the date range
                        if ($startDate && $updatedAt >= \Carbon\Carbon::parse($startDate)) {
                            return false;
                        }
                        if ($endDate && $updatedAt <= \Carbon\Carbon::parse($endDate)) {
                            return false;
                        }
                    }
                    
                    return true;
                });
            
            $familiesPerBarangay[] = $allFamilies->count();

            /**
             * 4Ps FAMILIES PER BARANGAY
             */
            $families4Ps = $allFamilies->filter(function($family) {
                return $family->is_4ps == true || $family->is_4ps == 1;
            })->count();
            
            $families4PsPerBarangay[] = $families4Ps;

            /**
             * INDIGENT FAMILIES PER BARANGAY
             */
            $familiesIndigent = $allFamilies->filter(function($family) {
                return $family->is_indigent == true || $family->is_indigent == 1;
            })->count();
            
            $familiesIndigentPerBarangay[] = $familiesIndigent;
        }


        $residentsPerBarangay = [];
        $malesPerBarangay = [];
        $femalesPerBarangay = [];
        $pwdsPerBarangay = [];
        $nonPwdsPerBarangay = [];
        $malePwdsPerBarangay = [];
        $femalePwdsPerBarangay = [];
        $wraPerBarangay = [];
        $ageGroupMalePerBarangay = [];
        $ageGroupFemalePerBarangay = [];
        $malePerAgePerBarangay = [];
        $femalePerAgePerBarangay = [];
        $pregnantPerBarangay = [];
        $lactatingPerBarangay = [];

        foreach ($barangays as $barangay) {
            $barangayName = $barangay->name;
            $barangayId = $barangay->id;

            $residentsCollection = Resident::whereHas('residenceHistories', function($query) use ($barangayId, $startDate, $endDate) {
                $query->whereHas('purok', function($q) use ($barangayId) {
                    $q->where('brgy_id', $barangayId);
                });
                
                if ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                }
                if ($startDate) {
                    $query->whereDate('created_at', '>=', $startDate);
                }
            })
            ->where('status', 'active')
            ->get()
            ->filter(function($resident) use ($barangayId, $endDate, $startDate) {
                // Get the latest residence history up to the end date
                $latestHistory = $resident->residenceHistories()
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                if (!$latestHistory || !$latestHistory->purok || $latestHistory->purok->brgy_id != $barangayId) {
                    return false;
                }

                // If status is 'moved' or 'deceased', check if updated_at falls within range
                if (in_array($latestHistory->status, ['moved', 'deceased'])) {
                    $updatedAt = \Carbon\Carbon::parse($latestHistory->updated_at);
                    
                    // Exclude if updated_at is within the date range
                    if ($startDate && $endDate) {
                        $start = \Carbon\Carbon::parse($startDate);
                        $end = \Carbon\Carbon::parse($endDate);
                        if ($updatedAt >= $start && $updatedAt <= $end) {
                            return false;
                        }
                    }
                }
                
                return true;
            });

            // Count total residents
            $residentsPerBarangay[$barangayName] = $residentsCollection->count();

            // Pre-filter residents by sex for efficiency
            $maleResidents = $residentsCollection->where('sex', 'male');
            $femaleResidents = $residentsCollection->where('sex', 'female');

            // Count by sex
            $malesPerBarangay[$barangayName] = $maleResidents->count();
            $femalesPerBarangay[$barangayName] = $femaleResidents->count();

            // Count PWDs
            $pwdsPerBarangay[$barangayName] = $residentsCollection->where('is_pwd', true)->count();
            $nonPwdsPerBarangay[$barangayName] = $residentsCollection->where('is_pwd', false)->count();
            $malePwdsPerBarangay[$barangayName] = $maleResidents->where('is_pwd', true)->count();
            $femalePwdsPerBarangay[$barangayName] = $femaleResidents->where('is_pwd', true)->count();

            // Count WRA (Women of Reproductive Age: 10-49 years old)
            $wraPerBarangay[$barangayName] = $femaleResidents->filter(function($resident) use ($end) {
                if (!$resident->birthdate) return false;
                $age = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);
                return $age >= 10 && $age <= 49;
            })->count();

            // Count pregnant women in this barangay
            $pregnantPerBarangay[$barangayName] = $femaleResidents->filter(function($resident) use ($endDate) {
                // Get the latest consultation for this resident up to the end date
                $latestConsultation = $resident->consultations()
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                // Check if they are pregnant based on latest consultation
                return $latestConsultation && $latestConsultation->is_pregnant == true;
            })->count();

            // Count lactating mothers in this barangay
            $lactatingPerBarangay[$barangayName] = $femaleResidents->filter(function($resident) use ($endDate) {
                // Get the latest consultation for this resident up to the end date
                $latestConsultation = $resident->consultations()
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                // Check if they are lactating based on latest consultation
                return $latestConsultation && $latestConsultation->is_lactating == true;
            })->count();

            // Initialize age group arrays for this barangay
            $ageGroupMalePerBarangay[$barangayName] = [];
            $ageGroupFemalePerBarangay[$barangayName] = [];
            $malePerAgePerBarangay[$barangayName] = [];
            $femalePerAgePerBarangay[$barangayName] = [];

            // Process each age group
            foreach ($ageGroups as $range) {
                if (str_contains($range, 'months')) {
                    // Parse months range (e.g., "0-6 months")
                    $parts = explode('-', str_replace(' months', '', $range));
                    $min = (int)$parts[0];
                    $max = isset($parts[1]) ? (int)$parts[1] : $min;

                    // Count males in this months-based age range
                    $maleCount = $maleResidents->filter(function($resident) use ($min, $max, $end) {
                        if (!$resident->birthdate) return false;
                        $ageInMonths = \Carbon\Carbon::parse($resident->birthdate)->diffInMonths($end);
                        return $ageInMonths >= $min && $ageInMonths <= $max;
                    })->count();

                    // Count females in this months-based age range
                    $femaleCount = $femaleResidents->filter(function($resident) use ($min, $max, $end) {
                        if (!$resident->birthdate) return false;
                        $ageInMonths = \Carbon\Carbon::parse($resident->birthdate)->diffInMonths($end);
                        return $ageInMonths >= $min && $ageInMonths <= $max;
                    })->count();

                } else {
                    // Parse years range (e.g., "20-59 years", "60+ years")
                    $parsedRange = str_replace(' years', '', $range);
                    
                    if (str_contains($parsedRange, '+')) {
                        $min = (int)str_replace('+', '', $parsedRange);
                        $max = null;
                    } else {
                        $parts = explode('-', $parsedRange);
                        $min = (int)$parts[0];
                        $max = isset($parts[1]) ? (int)$parts[1] : $min;
                    }

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
                $ageGroupMalePerBarangay[$barangayName][] = $maleCount;
                $ageGroupFemalePerBarangay[$barangayName][] = $femaleCount;
            }

            // Count residents by exact age (in years)
            foreach ($residentsCollection as $resident) {
                if (!$resident->birthdate) continue;
                
                $age = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);

                if ($resident->sex === 'male') {
                    $malePerAgePerBarangay[$barangayName][$age] = ($malePerAgePerBarangay[$barangayName][$age] ?? 0) + 1;
                } elseif ($resident->sex === 'female') {
                    $femalePerAgePerBarangay[$barangayName][$age] = ($femalePerAgePerBarangay[$barangayName][$age] ?? 0) + 1;
                }
            }

            // Sort age arrays by age (ascending)
            if (isset($malePerAgePerBarangay[$barangayName])) {
                ksort($malePerAgePerBarangay[$barangayName]);
            }
            if (isset($femalePerAgePerBarangay[$barangayName])) {
                ksort($femalePerAgePerBarangay[$barangayName]);
            }
        }   

        $residentsCollection = Resident::whereHas('residenceHistories', function ($q) use ($startDate, $endDate) {
            // No barangay filter - work across all barangays
            
            if ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            }
        })
        ->where('status', 'active')
        ->get()
        ->filter(function($resident) use ($endDate, $startDate) {
            // Get the latest residence history up to endDate
            $latestHistory = $resident->residenceHistories()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$latestHistory) {
                return false;
            }

            // If status is 'moved' or 'deceased', check if updated_at falls within range
            if (in_array($latestHistory->status, ['moved', 'deceased'])) {
                $updatedAt = \Carbon\Carbon::parse($latestHistory->updated_at);
                
                // Exclude if updated_at is within the date range
                if ($startDate && $endDate) {
                    $start = \Carbon\Carbon::parse($startDate);
                    $end = \Carbon\Carbon::parse($endDate);
                    if ($updatedAt >= $start && $updatedAt <= $end) {
                        return false;
                    }
                }
            }
            
            return true;
        });

        /**
         * SENIORS STATISTICS
         */
        $seniorsTotal = $residentsCollection->filter(function($r) use ($end) {
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

        /**
         * WRA (Women of Reproductive Age) STATISTICS
         */
        $wraTotal = $residentsCollection->filter(function($r) use ($end) {
            if (!$r->birthdate) return false;
            $age = \Carbon\Carbon::parse($r->birthdate)->diffInYears($end);
            return $r->sex === 'female' && $age >= 10 && $age <= 49;
        });

        $wra = $wraTotal->count();

        /**
         * AGE GROUP STATISTICS BY GENDER
         */
        $maleData = [];
        $femaleData = [];

        $maleResidents = $residentsCollection->where('sex', 'male');
        $femaleResidents = $residentsCollection->where('sex', 'female');

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
                    if (!$resident->birthdate) return false;
                    $ageInMonths = \Carbon\Carbon::parse($resident->birthdate)->diffInMonths($end);
                    return $ageInMonths >= $min && $ageInMonths <= $max;
                })->count();

                // Count females in this age range
                $femaleCount = $femaleResidents->filter(function($resident) use ($min, $max, $end) {
                    if (!$resident->birthdate) return false;
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
                    if (!$resident->birthdate) return false;
                    $ageInYears = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);
                    return $max ? ($ageInYears >= $min && $ageInYears <= $max) : ($ageInYears >= $min);
                })->count();

                // Count females in this age range
                $femaleCount = $femaleResidents->filter(function($resident) use ($min, $max, $end) {
                    if (!$resident->birthdate) return false;
                    $ageInYears = \Carbon\Carbon::parse($resident->birthdate)->diffInYears($end);
                    return $max ? ($ageInYears >= $min && $ageInYears <= $max) : ($ageInYears >= $min);
                })->count();
            }

            // Store counts for this age group
            $maleData[] = $maleCount;
            $femaleData[] = $femaleCount;
        }

        /**
         * SANITARY DATA (from households with latest history - ALL BARANGAYS)
         */
        $households4sanitary = Household::whereHas('householdResidenceHistory', function ($q) use ($startDate, $endDate) {
            // No barangay filter - work across all barangays
            
            if ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            }
        })
        ->where('status', 'active')
        ->get()
        ->filter(function($household) use ($endDate, $startDate) {
            $latestHistory = $household->householdResidenceHistory()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$latestHistory) {
                return false;
            }

            // If status is 'moved' or 'inactive', check if updated_at falls within range
            if (in_array($latestHistory->status, ['moved', 'inactive'])) {
                $updatedAt = \Carbon\Carbon::parse($latestHistory->updated_at);
                
                if ($startDate && $endDate) {
                    $start = \Carbon\Carbon::parse($startDate);
                    $end = \Carbon\Carbon::parse($endDate);
                    if ($updatedAt >= $start && $updatedAt <= $end) {
                        return false;
                    }
                }
            }
            
            return true;
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

        $wasteDisposalData = $households4sanitary->groupBy('waste_disposal')->map->count()->toArray();
        $waterSourceData = $households4sanitary->groupBy('water_source')->map->count()->toArray();

        $sanitaryData = [
            'with_sanitary_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'with_sanitary_toilet')->count(),
            'with_unsanitary_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'with_unsanitary_toilet')->count(),
            'without_toilet' => $households4sanitary->filter(fn($h) => $h->sanitary_toilet === 'without_toilet')->count(),
        ];


                // Get the maternal health program
        $maternalHealthProgram = HealthProgram::where('category', 'maternal_health_tcl')->first();

        $pregnantWomen = 0;
        $teenPregnancies = 0;
        $totalLactating = 0;

        // Pregnancy type breakdown
        $primis = 0;      // First pregnancy (para = 0)
        $multiPara = 0;   // Multiple pregnancies (para >= 2)
        $others = 0;      // Other cases

        if ($maternalHealthProgram) {
            // Get enrolled residents in maternal health program from filtered residents
            $enrolledInMaternal = EnrolledResident::where('program_id', $maternalHealthProgram->id)
                ->whereIn('resident_id', $residentsCollection->pluck('id'))  // 👈 Changed from $residents
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
            
            // Calculate pregnancy type breakdown
            foreach ($enrolledInMaternal as $enrollment) {
                $maternalRecord = $enrollment->maternalRecord;
                
                if ($maternalRecord && isset($maternalRecord->para)) {
                    $para = $maternalRecord->para;
                    
                    if ($para == 0) {
                        $primis++;
                    } elseif ($para >= 2) {
                        $multiPara++;
                    } else {
                        $others++;
                    }
                } else {
                    $others++;
                }
            }
        }

        $totalLactating = $residentsCollection->filter(function($resident) use ($endDate) {  // 👈 Changed from $residents
            // Get the latest consultation for this resident up to the end date
            $latestConsultation = $resident->consultations()
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Check if they are lactating based on latest consultation
            return $latestConsultation && $latestConsultation->is_lactating == true;
        })->count();

        // FAMILY PLANNING
        $familyPlanningProgram = HealthProgram::where('category', 'family_planning_tcl')->first();

        $familyPlanningMethods = [];
        $totalFamilyPlanningEnrollees = 0;

        if ($familyPlanningProgram) {
            // Get enrolled residents in family planning program from filtered residents
            $enrolledInFP = EnrolledResident::where('program_id', $familyPlanningProgram->id)
                ->whereIn('resident_id', $residentsCollection->pluck('id'))  // 👈 Changed from $residents
                ->with(['resident', 'familyPlanningData'])
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

            $totalFamilyPlanningEnrollees = $enrolledInFP->count();

            // Extract family planning data and group by previous_method
            $familyPlanningMethods = $enrolledInFP
                ->map(function($enrollment) {
                    return $enrollment->familyPlanningData;
                })
                ->filter()
                ->groupBy('previous_method')
                ->map(function($group) {
                    return $group->count();
                })
                ->toArray();
        }

        // CHILD HEALTHCARE
        $childHealthcareProgram = HealthProgram::where('category', 'child_healthcare_tcl')->first();

        $totalChildrenEnrolled = 0;
        $ficCount = 0;
        $cicCount = 0;
        $childrenWithWeightHeight = 0;

        // Nutritional status classification
        $normalWeight = 0;
        $underweight = 0;
        $severelyUnderweight = 0;
        $overweight = 0;
        $obese = 0;

        if ($childHealthcareProgram) {
            // Get enrolled residents in child healthcare program from filtered residents
            $enrolledInChildHealth = EnrolledResident::where('program_id', $childHealthcareProgram->id)
                ->whereIn('resident_id', $residentsCollection->pluck('id'))  // 👈 Changed from $residents
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
            // Overall counts
            'residents' => $totalResidents,
            'families' => $familiesCount,
            'households' => $householdsCount,

            // Age group data
            'ageGroups' => $ageGroups,
            'maleData' => $maleData,
            'femaleData' => $femaleData,

            // Per barangay data
            'barangays' => $barangays->pluck('name')->toArray(),
            'householdsPerBarangay' => $householdsPerBarangay,
            'familiesPerBarangay' => $familiesPerBarangay,
            'families4PsPerBarangay' => $families4PsPerBarangay,
            'familiesIndigentPerBarangay' => $familiesIndigentPerBarangay,

            // Per barangay detailed statistics
            'residentsPerBarangay' => $residentsPerBarangay,
            'malesPerBarangay' => $malesPerBarangay,
            'femalesPerBarangay' => $femalesPerBarangay,
            'pwdsPerBarangay' => $pwdsPerBarangay,
            'nonPwdsPerBarangay' => $nonPwdsPerBarangay,
            'malePwdsPerBarangay' => $malePwdsPerBarangay,
            'femalePwdsPerBarangay' => $femalePwdsPerBarangay,
            'wraPerBarangay' => $wraPerBarangay,
            'ageGroupMalePerBarangay' => $ageGroupMalePerBarangay,
            'ageGroupFemalePerBarangay' => $ageGroupFemalePerBarangay,
            'malePerAgePerBarangay' => $malePerAgePerBarangay,
            'femalePerAgePerBarangay' => $femalePerAgePerBarangay,
            'pregnantPerBarangay' => $pregnantPerBarangay,
            'lactatingPerBarangay' => $lactatingPerBarangay,

            // Municipality-wide statistics (NEW)
            'seniors' => $seniors,
            'wra' => $wra,
            'wasteDisposal' => $wasteDisposalData,
            'waterSource' => $waterSourceData,
            'sanitaryData' => $sanitaryData,


            'pregnantWomen' => $pregnantWomen,
            'teenPregnancies' => $teenPregnancies,
            'totalLactating' => $totalLactating,
            'primis' => $primis,
            'multiPara' => $multiPara,
            'pregnancyOthers' => $others,
            
            'totalFamilyPlanningEnrollees' => $totalFamilyPlanningEnrollees,
            'familyPlanningMethods' => $familyPlanningMethods,
            
            'totalChildrenEnrolled' => $totalChildrenEnrolled,
            'ficCount' => $ficCount,
            'cicCount' => $cicCount,
            'childrenWithWeightHeight' => $childrenWithWeightHeight,
            'normalWeight' => $normalWeight,
            'underweight' => $underweight,
            'severelyUnderweight' => $severelyUnderweight,
            'overweight' => $overweight,
            'obese' => $obese,
        ];

        return $data;

    }

}
