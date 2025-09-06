<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Midwife;
use App\Models\Schedules;

class ScheduleController extends Controller
{
    public function index()
    {
        // Get the current logged-in user's midwife record
        $midwife = Midwife::where('user_id', auth()->id())->first();

        // If midwife exists, fetch schedules for their barangay
        $schedules = collect(); // default empty collection
        if ($midwife) {
            $schedules = Schedules::where('brgy_id', $midwife->brgy_id)
                                  ->with('assignedBHWs', 'healthProgram', 'barangay')
                                  ->get();
        }

        // Pass schedules to the view
        return view('midwife.schedules', compact('schedules'));
    }
}
