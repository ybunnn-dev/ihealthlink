<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Midwife;
use App\Models\Schedules;
use App\Models\DailyActivities;
use App\Models\ActivityIcons;
use App\Models\ScheduleAssignments;
use App\Models\ActivityLog;
use App\Models\Personnel;  
use App\Models\Notification;  
use App\Services\Notifications\FireBase;  
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
            // Check if daily activities exist for this barangay
            $existingActivities = DailyActivities::where('brgy_id', $midwife->brgy_id)->count();
            
            // If no daily activities exist, create default ones
            if ($existingActivities === 0) {
                $this->createDefaultDailyActivities($midwife->brgy_id);
            }

            // Filter schedules to only include today and future dates
            $schedules = Schedules::where('brgy_id', $midwife->brgy_id)
                ->where('status', 'active')
                ->with(['barangay'])
                ->get();

            $dailyActivities = DailyActivities::where('brgy_id', $midwife->brgy_id)
                ->with('icon')
                ->get();
        } else {
            Log::warning('No midwife found for user ID: ' . auth()->id());
        }

        return view('midwife.schedules', compact('schedules', 'dailyActivities', 'activityIcons'));
    }

    /**
     * Create default daily activities for a barangay
     */
    private function createDefaultDailyActivities($brgyId)
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            DailyActivities::create([
                'day' => $day,
                'brgy_id' => $brgyId,
                'icon_id' => 1,
                'updated_by' => auth()->id(),
                'activities' => json_encode([]),
            ]);
        }

        Log::info("Default daily activities created for barangay: {$brgyId}");
    }



    public function updateDailyActivity(Request $request)
    {
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }
        
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
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

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

        $this->notifyBarangayPersonnel($midwife->brgy_id, $schedule);

         // Log the activity
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 6, // replace with correct module ID for households
            'activity'  => 'Created a new schedule ' . $validated['activity']. '.',
        ]);
        return response()->json([
            'result' => 'success',
            'message' => 'Schedule created successfully and notifications sent',
            'data' => [
                'schedule' => $schedule,
                'bhws' => $validated['bhws'] ?? []
            ]
        ]);
    }

    private function notifyBarangayPersonnel($brgyId, $schedule)
    {
        // Get all active personnel in this barangay
        $personnel = Personnel::where('brgy_id', $brgyId)
            ->where('status', 'active')
            ->with('user')
            ->get();

        // Format the date and time for the notification
        $scheduleDate = Carbon::parse($schedule->date)->format('F d, Y');
        $scheduleTime = Carbon::parse($schedule->time)->format('h:i A');

        $notificationSubject = 'New Activity: ' . $schedule->activity;
        $notificationMessage = "A new activity '{$schedule->activity}' has been scheduled for {$scheduleDate} at {$scheduleTime}. Venue: {$schedule->venue}";

        $notifiedCount = 0;

        foreach ($personnel as $person) {
            if ($person->user) {
                // Create notification in database (shows in UI bell icon)
                Notification::create([
                    'user_id' => $person->user->id,
                    'subject' => $notificationSubject,
                    'message' => $notificationMessage,
                    'module_id' => 6,
                    'is_read' => false
                ]);

                // Send push notification if user has FCM token
                if ($person->user->fcm_token) {
                    try {
                        FireBase::send(
                            $notificationSubject,
                            $notificationMessage,
                            [$person->user->fcm_token],
                            [
                                'schedule_id' => (string)$schedule->id,
                                'type' => 'new_schedule',
                                'date' => (string)$schedule->date,
                                'time' => (string)$schedule->time
                            ]
                        );
                        $notifiedCount++;
                    } catch (\Exception $e) {
                        Log::error('FCM Error for user ' . $person->user->id . ': ' . $e->getMessage());
                    }
                }
            }
        }
    }

    public function edit(Request $request, $id)
    {
       $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

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

         // Log the activity
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 6, // replace with correct module ID for households
            'activity'  => 'Updated scheduled acitvity: ' . $validated['activity']. '.',
        ]);
        
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

         // Log the activity
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 6, // replace with correct module ID for households
            'activity'  => 'Deleted scheduled acitvity: ' . $validated['activity']. '.',
        ]);
    }
}
