<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use App\Models\Barangay;

class BarangayLogs extends Controller
{
    public function index()
    {
        $midwife = Auth::user()->midwife;

        if (!$midwife) {
            return redirect('/');
        }

        $barangayId = $midwife->brgy_id;

        $barangay = Barangay::with(['midwives.user', 'bhw.user'])->find($barangayId);

        if (!$barangay) {
            abort(404, 'Barangay not found.');
        }

        $userIds = collect();

        foreach ($barangay->midwives as $midwife) {
            $userIds->push($midwife->user_id);
        }

        foreach ($barangay->bhw as $bhw) {
            $userIds->push($bhw->user_id);
        }

        $userIds = $userIds->unique()->values();

        //  Load the full user record
        $activityLogs = ActivityLog::whereIn('user_id', $userIds)
            ->with('user') // just the user relation
            ->latest()
            ->paginate(7);

        // Return the full user object for each activity
        $logs = $activityLogs->map(function ($log) {
            return (object) [
                'id' => $log->id,
                'user' => $log->user,
                'activity' => $log->activity,
                'created_at' => $log->created_at,
            ];
        });

        return view('midwife.log-list', ['activityLogs' => $logs]);
    }

    public function show(ActivityLog $log)
    {
        $log->load('user');
        
        // Convert to array and clean all strings
        $data = $log->toArray();
        
        // Recursively clean all string values
        array_walk_recursive($data, function(&$value) {
            if (is_string($value)) {
                // Remove any invalid UTF-8 sequences
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
        });
        
        return response()->json($data);
    }
}
