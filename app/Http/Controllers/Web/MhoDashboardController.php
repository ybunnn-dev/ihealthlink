<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Resident;
use App\Models\HealthProgram;
use App\Models\EnrolledResident;
use App\Models\Barangay;

class MhoDashboardController extends Controller
{
    public function index()
    {
        // Total stats across all barangays
        $totalResidents = Resident::where('status', 'active')->count();
        
        $residentCollection = Resident::where('status', 'active')->get();
        
        $under5 = $residentCollection->filter(function($resident) {
            return Carbon::parse($resident->birthdate)->age < 5;
        })->count();

        $sixtyUp = $residentCollection->filter(function($resident) {
            return Carbon::parse($resident->birthdate)->age >= 60;
        })->count();

        $pregnantCount = Resident::where('status', 'active')
            ->whereHas('basicHealthRecord', function($q) {
                $q->where('is_pregnant', 1);
            })
            ->count();

        // Enrolled stats across all barangays
        $enrolledStats = $this->getEnrolledResidentStats();
        $philpenStats = $this->getPhilpenConsultationStats();

        // Stats by barangay
        $barangayStats = $this->getBarangayBreakdown();

        return view('mho.dashboard', [
            'totalResidents' => $totalResidents,
            'under5' => $under5,
            'sixtyUp' => $sixtyUp,
            'pregnant' => $pregnantCount,
            'enrolledStats' => $enrolledStats,
            'philpen' => $philpenStats,
            'barangayStats' => $barangayStats,
        ]);
    }

    private function getEnrolledResidentStats()
    {
        $categories = ['child_healthcare_tcl', 'family_planning_tcl', 'maternal_health_tcl'];
        
        $startDate = Carbon::now()->subMonths(4)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        // Generate all months for the last 5 months
        $allMonths = [];
        for ($i = 4; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $allMonths[] = [
                'key' => $date->format('Y-m'),
                'month' => $date->format('F Y'),
                'year' => $date->year,
                'month_num' => $date->month,
                'count' => 0
            ];
        }
        
        $programs = HealthProgram::whereIn('category', $categories)->get();
        
        $enrolledStats = EnrolledResident::whereHas('program', function($q) use ($categories) {
                $q->whereIn('category', $categories);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('program:id,name,category')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('program_id');
        
        $result = $programs->map(function($program) use ($enrolledStats, $allMonths) {
            $programEnrollments = $enrolledStats->get($program->id);
            
            if ($programEnrollments) {
                $monthlyData = $programEnrollments->groupBy(function($enrollment) {
                    return Carbon::parse($enrollment->created_at)->format('Y-m');
                })
                ->map(function($monthGroup) {
                    $firstInMonth = $monthGroup->first();
                    return [
                        'key' => Carbon::parse($firstInMonth->created_at)->format('Y-m'),
                        'month' => Carbon::parse($firstInMonth->created_at)->format('F Y'),
                        'year' => Carbon::parse($firstInMonth->created_at)->year,
                        'month_num' => Carbon::parse($firstInMonth->created_at)->month,
                        'count' => $monthGroup->count()
                    ];
                });
                
                $filledMonths = collect($allMonths)->map(function($month) use ($monthlyData) {
                    $existingMonth = $monthlyData->firstWhere('key', $month['key']);
                    return $existingMonth ?? $month;
                });
            } else {
                $filledMonths = collect($allMonths);
            }
            
            return [
                'program_id' => $program->id,
                'program_name' => $program->name,
                'category' => $program->category,
                'monthly_data' => $filledMonths->values()
            ];
        })->values();
        
        return $result;
    }

    private function getPhilpenConsultationStats()
    {
        $philpenResidents = EnrolledResident::whereHas('program', function($q) {
                $q->where('category', 'philpen_tcl');
            })
            ->with(['resident', 'consultations' => function($q) {
                $q->orderBy('consultation_date', 'desc');
            }])
            ->get();

        $stats = [
            'complete' => 0,
            'incomplete' => 0,
            'no_consultation' => 0,
        ];

        foreach ($philpenResidents as $enrolledResident) {
            $latestConsultation = $enrolledResident->consultations->first();
            
            if (!$latestConsultation) {
                $stats['no_consultation']++;
            } elseif ($latestConsultation->status === 'completed') {
                $stats['complete']++;
            } else {
                $stats['incomplete']++;
            }
        }

        return $stats;
    }

    /**
     * Get demographic statistics broken down by barangay
     */
    private function getBarangayBreakdown()
    {
        return Barangay::where('status', 'active')
            ->with([
                'puroks' => function($q) {
                    $q->where('status', 'active')
                        ->with(['households' => function($qh) {
                            $qh->where('status', 'active')
                                ->with(['families' => function($qf) {
                                    $qf->where('status', 'active')
                                        ->with(['residents' => function($qr) {
                                            $qr->where('status', 'active');
                                        }]);
                                }]);
                        }]);
                }
            ])
            ->get()
            ->map(function($barangay) {
                // Collect all residents through the relationship chain
                $residents = $barangay->puroks
                    ->flatMap(function($purok) {
                        return $purok->households
                            ->flatMap(function($household) {
                                return $household->families
                                    ->flatMap(function($family) {
                                        return $family->residents;
                                    });
                            });
                    })
                    ->unique('id');
                
                return [
                    'barangay_id' => $barangay->id,
                    'barangay_name' => $barangay->name,
                    'total_residents' => $residents->count(),
                    'under_5' => $residents->filter(function($r) {
                        return Carbon::parse($r->birthdate)->age < 5;
                    })->count(),
                    'sixty_plus' => $residents->filter(function($r) {
                        return Carbon::parse($r->birthdate)->age >= 60;
                    })->count(),
                    'pregnant' => $residents->filter(function($r) {
                        return $r->basicHealthRecord && $r->basicHealthRecord->is_pregnant;
                    })->count(),
                ];
            })
            ->sortByDesc('total_residents')
            ->values();
    }
}
