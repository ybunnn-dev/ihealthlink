<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Midwife;
use App\Models\Schedules;
use App\Models\DailyActivities;
use App\Models\ActivityIcons;

class ScheduleController extends Controller
{
    public function index()
    {
        // Get the current logged-in user's midwife record
        $midwife = Midwife::where('user_id', auth()->id())->first();

        $schedules = collect(); // default empty collection
        $dailyActivities = collect(); // default empty collection
        $activityIcons = ActivityIcons::all();

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
        //can you log the data here before returning tghe view?
        // Pass both to the view
        \Log::info('Daily Activities Data:', $dailyActivities->toArray());
        
        return view('midwife.schedules', compact('schedules', 'dailyActivities', 'activityIcons'));
    }

    public function updateDailyActivity(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'id' => 'required|exists:daily_activities,id',
            'newName' => 'required|string|max:255',
            'day' => 'required|string|max:50',
            'icon_id' => 'nullable|exists:activity_icons,id',
            'updated_by' => 'nullable|integer', // optional
        ]);

        // Find the activity
        $dailyActivity = DailyActivities::findOrFail($validated['id']);

        // Update using mass assignment
        $dailyActivity->update([
            'activities' => $validated['newName'],
            'day' => $validated['day'],
            'icon_id' => $validated['icon_id'] ?? $dailyActivity->icon_id,
            'updated_by' => $validated['updated_by'] ?? auth()->id(),
        ]);

        \Log::info('Updated Activity Saved:', $dailyActivity->toArray());

        return response()->json([
            'result' => 'success',
            'data' => $dailyActivity
        ]);
    }
}
