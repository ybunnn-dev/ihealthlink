<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Midwife;
use App\Models\Schedules;
use App\Models\DailyActivities;

class ScheduleController extends Controller
{
    public function index()
    {
        // Get the current logged-in user's midwife record
        $midwife = Midwife::where('user_id', auth()->id())->first();

        $schedules = collect(); // default empty collection
        $dailyActivities = collect(); // default empty collection

        if ($midwife) {
            // Fetch schedules for their barangay
            $schedules = Schedules::where('brgy_id', $midwife->brgy_id)
                                  ->with('assignedBHWs', 'healthProgram', 'barangay')
                                  ->get();

            // Fetch daily activities for their barangay
            $dailyActivities = DailyActivities::where('brgy_id', $midwife->brgy_id)
                                              ->with('icon')
                                              ->get();
        }

        // Pass both to the view
        return view('midwife.schedules', compact('schedules', 'dailyActivities'));
    }
}
