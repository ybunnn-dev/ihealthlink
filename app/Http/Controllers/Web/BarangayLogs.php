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
            ->get();

        // Return the full user object for each activity
        $logs = $activityLogs->map(function ($log) {
            return (object) [
                'id' => $log->id,
                'user' => $log->user,
                'activity' => $log->activity,
                'created_at' => $log->created_at,
            ];
        });

        \Log::info($logs);
        return view('midwife.log-list', ['activityLogs' => $logs]);
    }


}
