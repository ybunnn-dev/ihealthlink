<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\DailyActivities;
use App\Models\Schedules;
use App\Models\Midwife;
use App\Models\Resident;
use App\Models\Medicine;
use App\Models\HealthProgram;
use App\Models\EnrolledResident;

class DashboardController extends Controller
{
    public function index($barangay)
    {   
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $schedules = Schedules::where('brgy_id', $personnel->brgy_id)
                                            ->where('status', 'active')
                                            ->whereDate('date', '>=', \Carbon\Carbon::today())
                                            ->with('barangay')
                                            ->get();

        $residents = Resident::whereHas('family.household.purok', function($q) use ($personnel) {
                                $q->where('brgy_id', $personnel->brgy_id);
                            });

        $totalResidents = $residents->count();
        
        $residentCollection = $residents->get();

        $under5 = $residentCollection->filter(function($resident) {
            return \Carbon\Carbon::parse($resident->birthdate)->age < 5;
        })->count();

        $sixtyUp = $residentCollection->filter(function($resident) {
            return \Carbon\Carbon::parse($resident->birthdate)->age >= 60;
        })->count();

        $pregnantCount = Resident::whereHas('family.household.purok', function($q) use ($personnel) {
            $q->where('brgy_id', $personnel->brgy_id);
            })
            ->whereHas('basicHealthRecord', function($q) {
                $q->where('is_pregnant', 1);
            })
            ->count();
            
        $medicines = Medicine::withSum('activeInventories as total_stock', 'stock')
            ->where('brgy_id', $personnel->brgy_id)
            ->orderByDesc('total_stock')
            ->limit(10)
            ->get();

        // Call the private method
        $enrolledStats = $this->getEnrolledResidentStats($personnel);
        \Log::info($medicines);
        return view('midwife.dashboard', [
            'barangay' => $barangay,
            'scheduledActivities' => $schedules,
            'totalResidents' => $totalResidents,
            'under5' => $under5,
            'sixtyUp' => $sixtyUp,
            'pregnant' => $pregnantCount,
            'medicines' => $medicines,
            'enrolledStats' => $enrolledStats,
        ]);
    }

    private function getEnrolledResidentStats($personnel)
    {
        $categories = ['child_healthcare_tcl', 'family_planning_tcl', 'maternal_health_tcl'];
        
        $startDate = \Carbon\Carbon::now()->subMonths(4)->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();
        
        // Generate all months for the last 5 months
        $allMonths = [];
        for ($i = 4; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $allMonths[] = [
                'key' => $date->format('Y-m'),
                'month' => $date->format('F Y'),
                'year' => $date->year,
                'month_num' => $date->month,
                'count' => 0
            ];
        }
        
        // Get all programs in the categories
        $programs = \App\Models\HealthProgram::whereIn('category', $categories)->get();
        
        $enrolledStats = EnrolledResident::whereHas('program', function($q) use ($categories) {
                $q->whereIn('category', $categories);
            })
            ->whereHas('resident.family.household.purok', function($q) use ($personnel) {
                $q->where('brgy_id', $personnel->brgy_id);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('program:id,name,category')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('program_id');
        
        // Build result with all programs, even those with no enrollments
        $result = $programs->map(function($program) use ($enrolledStats, $allMonths) {
            // Get enrollments for this program
            $programEnrollments = $enrolledStats->get($program->id);
            
            // If there are enrollments, group by month
            if ($programEnrollments) {
                $monthlyData = $programEnrollments->groupBy(function($enrollment) {
                    return \Carbon\Carbon::parse($enrollment->created_at)->format('Y-m');
                })
                ->map(function($monthGroup) {
                    $firstInMonth = $monthGroup->first();
                    return [
                        'key' => \Carbon\Carbon::parse($firstInMonth->created_at)->format('Y-m'),
                        'month' => \Carbon\Carbon::parse($firstInMonth->created_at)->format('F Y'),
                        'year' => \Carbon\Carbon::parse($firstInMonth->created_at)->year,
                        'month_num' => \Carbon\Carbon::parse($firstInMonth->created_at)->month,
                        'count' => $monthGroup->count()
                    ];
                });
                
                // Merge with all months to fill gaps
                $filledMonths = collect($allMonths)->map(function($month) use ($monthlyData) {
                    $existingMonth = $monthlyData->firstWhere('key', $month['key']);
                    return $existingMonth ?? $month;
                });
            } else {
                // No enrollments for this program, use all months with zero counts
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
}
