<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DailyActivities;
use App\Models\Schedules;
use App\Models\Midwife;
use App\Models\Resident;

class DashboardController extends Controller
{
    // Method to show the dashboard
    public function index($barangay)
    {   
        $midwife = Midwife::where('user_id', auth()->id())->first();
        $dailyActivities = collect(); // default empty collection

        $dailyActivities = DailyActivities::where('brgy_id', $midwife->brgy_id)
                                              ->with('icon')
                                              ->get();

        $schedules = Schedules::where('brgy_id', $midwife->brgy_id)
                                            ->where('status', 'active')
                                            ->with('healthProgram', 'barangay')
                                            ->get();

        // Resident statistics
        $residents = Resident::whereHas('family.household.purok', function($q) use ($midwife) {
                                $q->where('brgy_id', $midwife->brgy_id);
                            });

        $totalResidents = $residents->count();
        
        $residentCollection = $residents->get(); // actually fetch the residents

        $under5 = $residentCollection->filter(function($resident) {
            return \Carbon\Carbon::parse($resident->birthdate)->age < 5;
        })->count();

        $sixtyUp = $residentCollection->filter(function($resident) {
            return \Carbon\Carbon::parse($resident->birthdate)->age >= 60;
        })->count();

        $pregnantCount = Resident::whereHas('family.household.purok', function($q) use ($midwife) {
            $q->where('brgy_id', $midwife->brgy_id);
            })
            ->whereHas('basicHealthRecord', function($q) {
                $q->where('is_pregnant', 1);
            })
            ->count();

          return view('midwife.dashboard', [
            'barangay' => $barangay,
            'dailyActivities' => $dailyActivities,
            'scheduledActivities' => $schedules,
            'totalResidents' => $totalResidents,
            'under5' => $under5,
            'sixtyUp' => $sixtyUp,
            'pregnant' => $pregnantCount,
        ]);
    }
}
