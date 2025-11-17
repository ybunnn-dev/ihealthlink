<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\Medicine;
use App\Models\MedicineInventory;
use App\Models\Schedules;
use App\Models\DailyActivities;
use App\Models\UserManual;
use App\Models\HealthProgram;
use Carbon\Carbon;

class PreloadController extends Controller
{
    public function index(Request $request)
    {
        
        // Assuming your user model has a `brgy_id` or similar relation
        $user = $request->user();

        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $barangayId = $personnel->brgy_id;

        if (!$user || !$barangayId) {
            return response()->json([
                'message' => 'User does not belong to any barangay.'
            ], 400);
        }

        $barangay = Barangay::with(['puroks'])
            ->where('id', $barangayId)
            ->first();

        if (!$barangay) {
            return response()->json(['message' => 'Barangay not found.'], 404);
        }

        $puroks = $barangay->puroks;
        $medicines = Medicine::where('brgy_id', $barangay->id)->get();

        // Fetch inventories through the medicine IDs belonging to this barangay
        $inventories = MedicineInventory::whereIn('medicine_id', $medicines->pluck('id'))->get();

        // Get schedules that are active AND dated today or in the future
        $schedules = Schedules::where('brgy_id', $barangay->id)
            ->where('status', 'active')
            ->whereDate('date', '>=', Carbon::today())
            ->get();
        $dailyActivities = DailyActivities::where('brgy_id', $barangay->id)->get();
        $userManuals = UserManual::where('action_type', 'active')->get();
        $health_programs = HealthProgram::where('status', 'active')->get();
        // Return all in one payload
        return response()->json([
            'barangay' => $barangay,
            'puroks' => $puroks,
            'medicines' => $medicines,
            'inventories' => $inventories,
            'schedules' => $schedules,
            'daily_activities' => $dailyActivities,
            'user_manuals' => $userManuals,
            'health_programs' => $health_programs,
        ]);
    }
}
