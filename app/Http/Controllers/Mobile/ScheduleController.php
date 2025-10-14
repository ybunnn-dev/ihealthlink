<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Schedules;
use App\Models\BHW;


class ScheduleController extends Controller
{
    public function index(Request $request)
    {

       $user = Auth::user();

        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }
     
        $brgyId = $personnel->brgy_id;

        // extract payload month/year
        $month = $request->input('month');
        $year = $request->input('year');

        $schedules = Schedules::where('brgy_id', $brgyId)
            ->whereMonth('date', $month)   
            ->whereYear('date', $year)
            ->get();

        return response()->json($schedules);
    }
}
