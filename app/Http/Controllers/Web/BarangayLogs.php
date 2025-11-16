<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use App\Models\Barangay;
use App\Models\User;
use App\Models\Module;
use Carbon\Carbon;

class BarangayLogs extends Controller
{
    public function index(Request $request)
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

        foreach ($barangay->midwives as $midwifeRec) {
            $userIds->push($midwifeRec->user_id);
        }

        foreach ($barangay->bhw as $bhwRec) {
            if ($bhwRec->user && $bhwRec->user->role_id == 3) {
                $userIds->push($bhwRec->user_id);
            }
        }

        $bhwWebUsers = User::where('role_id', 4)
            ->whereHas('personnel', function ($q) use ($barangayId) {
                $q->where('brgy_id', $barangayId);
            })
            ->pluck('id');
        
        $userIds = $userIds->merge($bhwWebUsers)->unique()->values();

        $query = ActivityLog::whereIn('user_id', $userIds)->with('user');

        // Apply search filter (activity is encrypted, search in PHP after decryption)
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $allLogs = $query->get();
            
            $filteredIds = $allLogs->filter(function ($log) use ($searchTerm) {
                $firstName = strtolower($log->user->firstName ?? '');
                $lastName = strtolower($log->user->lastName ?? '');
                $activity = strtolower($log->activity ?? ''); // decrypted automatically by model
                $fullName = trim($firstName . ' ' . $lastName);
                
                return str_contains($firstName, $searchTerm) || 
                    str_contains($lastName, $searchTerm) || 
                    str_contains($fullName, $searchTerm) ||
                    str_contains($activity, $searchTerm);
            })->pluck('id')->toArray();

            $query = ActivityLog::whereIn('id', $filteredIds);
        }

        // Apply module filter
        if ($request->filled('module_id') && $request->module_id !== '') {
            $query->where('module_id', $request->module_id);
        }

        // Apply date filter
        if ($request->filled('date_filter') && $request->date_filter !== 'all') {
            if ($request->date_filter === 'last_week') {
                $query->where('created_at', '>=', Carbon::now()->subWeek());
            } elseif ($request->date_filter === 'last_year') {
                $query->where('created_at', '>=', Carbon::now()->subYear());
            } elseif ($request->date_filter === 'custom' && $request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date)->startOfDay();
                $toDate = Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            }
        }

        // Sort by date
        $sortOrder = $request->get('sort_date', 'desc');
        $query->orderBy('created_at', $sortOrder);

        $activityLogs = $query->paginate(7);

        $logs = $activityLogs->map(function ($log) {
            return (object) [
                'id' => $log->id,
                'user' => $log->user,
                'activity' => $log->activity, // already decrypted
                'module_id' => $log->module_id,
                'created_at' => $log->created_at,
            ];
        });

        // Get all modules for the dropdown
        $modules = Module::all();

        // Return JSON for AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'html' => view('components.logs.log-table-rows', compact('logs'))->render(),
                'pagination' => view('components.logs.log-pagination', compact('activityLogs'))->render(),
            ]);
        }

        return view('midwife.log-list', compact('activityLogs', 'logs', 'modules'));
    }

    public function show(ActivityLog $log)
    {
        $log->load('user');
        
        // Convert to array first
        $data = $log->toArray();
        
        // Use the original Carbon objects from the model, NOT the string from toArray()
        $data['created_at'] = $log->created_at
            ->timezone('Asia/Manila')
            ->format('M d, Y - h:i A');
        
        $data['updated_at'] = $log->updated_at
            ->timezone('Asia/Manila')
            ->format('M d, Y - h:i A');
        
        // For user timestamps - use the Carbon objects from the relationship
        if ($log->user) {
            $data['user']['created_at'] = $log->user->created_at
                ->timezone('Asia/Manila')
                ->format('M d, Y - h:i A');
            
            $data['user']['updated_at'] = $log->user->updated_at
                ->timezone('Asia/Manila')
                ->format('M d, Y - h:i A');
        }
        
        // Recursively clean all string values
        array_walk_recursive($data, function(&$value) {
            if (is_string($value)) {
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
        });
        
        return response()->json($data);
    }

}
