<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DailyActivities;
use App\Models\Schedules;
use App\Models\Midwife;

class MidwifeDashboardController extends Controller
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
                                            ->with('assignedBHWs', 'healthProgram', 'barangay')
                                            ->get();

        // You can pass the barangay name/id to the view if needed
          return view('midwife.dashboard', [
            'barangay' => $barangay,
            'dailyActivities' => $dailyActivities,
            'scheduledActivities' => $schedules
        ]);
    }
}
