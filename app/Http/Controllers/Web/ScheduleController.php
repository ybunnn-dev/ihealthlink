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
                                  ->where('status', 'active')
                                  ->with('assignedBHWs', 'healthProgram', 'barangay')

                                  ->get();

            // Fetch daily activities for their barangay
            $dailyActivities = DailyActivities::where('brgy_id', $midwife->brgy_id)
                                              ->with('icon')
                                              ->get();
        }
        //can you log the data here before returning tghe view?
        // Pass both to the view
        
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
            'health_program_id' => 'nullable|exists:health_programs,id',
            'bhws' => 'nullable|array',
            'bhws.*.id' => 'required|integer|exists:personnel,id',
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
            'health_program_id' => $validated['health_program_id'] ?? null,
            'added_by' => auth()->id(),
        ]);

        // Assign BHWs if provided
        if (!empty($validated['bhws'])) {
            foreach ($validated['bhws'] as $bhw) {
                ScheduleAssignments::create([
                    'schedule_id' => $schedule->id,
                    'personnel_id' => $bhw['id'],
                ]);
            }
        }

        // Log the saved data
        \Log::info('New Schedule Saved:', [
            'schedule' => $schedule->toArray(),
            'bhws' => $validated['bhws'] ?? [],
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
            'health_program_id' => 'nullable|exists:health_programs,id',
            'bhws' => 'nullable|array',
            'bhws.*.id' => 'required|integer|exists:personnel,id',
        ]);

        $schedule = Schedules::findOrFail($id);
        $normalizedDate = Carbon::createFromFormat('m/d/Y', $validated['date'])->format('Y-m-d');
        $normalizedTime = Carbon::parse($validated['time'])->format('H:i:s');
        // Normalize date/time
        $schedule->activity = $validated['activity'];
        $schedule->date = $normalizedDate;
        $schedule->time = $normalizedTime;
        $schedule->venue = $validated['venue'];
        $schedule->health_program_id = $validated['health_program_id'] ?? null;

        $schedule->save();

        // Sync BHWs with status
        $newBHWIds = collect($validated['bhws'] ?? [])->pluck('id')->toArray();

        // Get all current assignments
        $currentAssignments = ScheduleAssignments::where('schedule_id', $schedule->id)->get();

        foreach ($currentAssignments as $assignment) {
            if (in_array($assignment->personnel_id, $newBHWIds)) {
                // Previously inactive or active → set active
                $assignment->status = 'active';
                $assignment->save();

                // Remove from $newBHWIds so we don’t create duplicate
                $newBHWIds = array_diff($newBHWIds, [$assignment->personnel_id]);
            } else {
                // Not in payload → set inactive
                $assignment->status = 'inactive';
                $assignment->save();
            }
        }

        // Add remaining new BHWs
        foreach ($newBHWIds as $bhwId) {
            ScheduleAssignments::create([
                'schedule_id' => $schedule->id,
                'personnel_id' => $bhwId,
                'status' => 'active'
            ]);
        }

        \Log::info('Updated schedule:', [
            'schedule' => $schedule->toArray(),
            'bhws' => $validated['bhws'] ?? []
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Schedule updated successfully',
            'data' => [
                'schedule' => $schedule,
                'bhws' => $validated['bhws'] ?? []
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
