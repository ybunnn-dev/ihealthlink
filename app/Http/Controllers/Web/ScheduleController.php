<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Midwife;
use App\Models\Schedules;
use App\Models\DailyActivities;
use App\Models\ActivityIcons;
use App\Models\ScheduleAssignments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function index()
    {
        // Get the current logged-in user's midwife record
        $midwife = Midwife::where('user_id', auth()->id())->first();

        $schedules = collect();
        $dailyActivities = collect();
        $activityIcons = ActivityIcons::all();

        if ($midwife) {
            // FIXED: Added 'user' relationship to activeBhws
            $schedules = Schedules::where('brgy_id', $midwife->brgy_id)
                ->where('status', 'active')
                ->with([
                    'barangay'
                ])
                ->get();

            // Detailed logging with user info
            Log::info('=== Schedules Data ===');
            Log::info('Midwife ID: ' . $midwife->id);
            Log::info('Barangay ID: ' . $midwife->brgy_id);
            Log::info('Total schedules found: ' . $schedules->count());
            

            $dailyActivities = DailyActivities::where('brgy_id', $midwife->brgy_id)
                ->with('icon')
                ->get();
                
            Log::info('=== Daily Activities ===');
            Log::info('Total activities: ' . $dailyActivities->count());
        } else {
            Log::warning('No midwife found for user ID: ' . auth()->id());
        }

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

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'activity' => 'required|string|max:255',
            'date' => 'required|string',
            'time' => 'required|string|max:50',
            'venue' => 'required|string|max:255',
        ]);

        $normalizedDate = Carbon::createFromFormat('m/d/Y', $validated['date'])->format('Y-m-d');
        $normalizedTime = Carbon::createFromFormat('H:i', $validated['time'])->format('H:i:s');

        // Get the current midwife (and their barangay ID)
        $midwife = Midwife::where('user_id', auth()->id())->firstOrFail();

        // Save the schedule
        $schedule = Schedules::create([
            'activity' => $validated['activity'],
            'date' => $normalizedDate,
            'time' => $normalizedTime,
            'venue' => $validated['venue'],
            'brgy_id' => $midwife->brgy_id,
            'added_by' => auth()->id(),
        ]);

        return response()->json([
            'result' => 'success',
            'message' => 'Schedule created successfully',
            'data' => [
                'schedule' => $schedule,
                'bhws' => $validated['bhws'] ?? []
            ]
        ]);
    }

    public function edit(Request $request, $id)
    {
        // Validate payload
        $validated = $request->validate([
            'activity' => 'required|string|max:255',
            'date' => 'required|string',
            'time' => 'required|string|max:50',
            'venue' => 'required|string|max:255',
        ]);

        $schedule = Schedules::findOrFail($id);
        $normalizedDate = Carbon::createFromFormat('m/d/Y', $validated['date'])->format('Y-m-d');
        $normalizedTime = Carbon::parse($validated['time'])->format('H:i:s');
        // Normalize date/time
        $schedule->activity = $validated['activity'];
        $schedule->date = $normalizedDate;
        $schedule->time = $normalizedTime;
        $schedule->venue = $validated['venue'];

        $schedule->save();


        return response()->json([
            'success' => true,
            'message' => 'Schedule updated successfully',
            'data' => [
                'schedule' => $schedule,
            ]
        ]);
    }
    public function softDelete($id)
    {
        $schedule = Schedules::findOrFail($id);
        $schedule->status = 'inactive'; // soft delete
        $schedule->save();

        \Log::info('Schedule soft deleted', ['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => 'Schedule marked as inactive',
            'data' => ['id' => $id]
        ]);
    }
}
