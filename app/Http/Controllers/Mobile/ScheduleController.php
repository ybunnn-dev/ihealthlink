<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Schedules;
use App\Models\BHW;


class ScheduleController extends Controller
{
    public function getSched(Request $request)
    {
        $user = $request->user();

        \Log::info($user);

        $bhwPersonnel = $user->bhw; 
        
        \Log::info($bhwPersonnel);
        /*if (!$bhwPersonnel) {
            return response()->json(['error' => 'BHW not found or unauthorized'], 403);
        }*/

        $brgyId = $bhwPersonnel->brgy_id;

        // extract payload month/year
        $month = $request->input('month');
        $year = $request->input('year');

        $schedules = Schedules::where('brgy_id', $brgyId)
            ->whereMonth('date', $month)   // assuming you have a `schedule_date` column
            ->whereYear('date', $year)
            ->get();

        \Log::info('vakla');
        return response()->json($schedules);
    }
}
