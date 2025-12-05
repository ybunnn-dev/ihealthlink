<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BHWCredentialsMail;
use App\Mail\MidwifeCredentialsMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


use App\Models\BHW;
use App\Models\Personnel;
use App\Models\Barangay;
use App\Models\User;
use App\Models\Midwife;
use App\Models\ActivityLog;

class BHWController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $midwifePersonnel = Midwife::where('user_id', $user->id)
            ->where('role_id', 2)
            ->first();

        if (!$midwifePersonnel || !$midwifePersonnel->brgy_id) {
            if ($request->ajax()) {
                return response()->json(['html' => '', 'status' => 'no_data']);
            }
            return view('midwife.BHWs', ['bhws' => collect()]);
        }

        // Get all BHWs for this barangay
        $query = Personnel::where('personnel.brgy_id', $midwifePersonnel->brgy_id)
            ->where('personnel.status', 'active')
            ->whereHas('user', function ($q) {
                $q->whereIn('role_id', [3, 4]);
            })
            ->with('user');

        // Date filtering at DB level (before fetching)
        $sortDate = $request->input('sort_date', 'all');
        if ($sortDate === 'last_week') {
            $query->where('personnel.created_at', '>=', now()->subWeek());
        } elseif ($sortDate === 'last_month') {
            $query->where('personnel.created_at', '>=', now()->subMonth());
        } elseif ($sortDate === 'last_year') {
            $query->where('personnel.created_at', '>=', now()->subYear());
        }

        // Fetch all records
        $allBhws = $query->get();

        // Apply search filter in PHP (after decryption)
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $allBhws = $allBhws->filter(function($bhw) use ($searchTerm) {
                // Search by BHW ID
                $bhwId = 'BHW-' . str_pad($bhw->id, 3, '0', STR_PAD_LEFT);
                if (str_contains(strtolower($bhwId), $searchTerm)) {
                    return true;
                }
                
                // Search by full name (encrypted fields are auto-decrypted by accessor)
                $fullName = strtolower($bhw->user->firstName . ' ' . $bhw->user->middleName . ' ' . $bhw->user->lastName);
                $nameWithoutMiddle = strtolower($bhw->user->firstName . ' ' . $bhw->user->lastName);
                
                return str_contains($fullName, $searchTerm) || str_contains($nameWithoutMiddle, $searchTerm);
            });
        }

        // Apply sorting in PHP (since birthdate is encrypted)
        $sortBy = $request->input('sort_by', 'alphabetical');
        
        if ($sortBy === 'age_asc') {
            $allBhws = $allBhws->sortBy(function($bhw) {
                return $this->calculateAge($bhw->user->birthdate);
            })->values();
        } elseif ($sortBy === 'age_desc') {
            $allBhws = $allBhws->sortByDesc(function($bhw) {
                return $this->calculateAge($bhw->user->birthdate);
            })->values();
        } else {
            // Alphabetical
            $allBhws = $allBhws->sortBy(function($bhw) {
                return $bhw->user->lastName . ' ' . $bhw->user->firstName;
            })->values();
        }

        // Manually paginate the filtered collection
        $page = $request->get('page', 1);
        $perPage = 8;
        $total = $allBhws->count();
        $results = $allBhws->forPage($page, $perPage);
        
        $bhws = new \Illuminate\Pagination\LengthAwarePaginator(
            $results, 
            $total, 
            $perPage, 
            $page, 
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.bhw.bhw-table', ['bhws' => $bhws])->render(),
                'pagination' => (string)$bhws->links(),
                'status' => 'success'
            ]);
        }

        return view('midwife.BHWs', compact('bhws'));
    }

    // Helper method to calculate age from encrypted birthdate
    private function calculateAge($birthdate)
    {
        if (!$birthdate) {
            return 0;
        }

        try {
            $date = \Carbon\Carbon::parse($birthdate);
            return $date->age;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function show(Request $request, Personnel $personnel)
    {
        if ($personnel->brgy_id !== auth()->user()->personnel->brgy_id) {
            abort(403, 'Unauthorized access to this personnel record');
        }

        $personnel->load('user', 'barangay');

        $query = ActivityLog::where('user_id', $personnel->user_id);

        // Date Filters
        $dateFilter = $request->input('date_filter');
        if ($dateFilter) {
            switch ($dateFilter) {
                case 'last_week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'last_month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
            }
        }

        // Fetch all logs before pagination
        $allLogs = $query->latest()->get();

        // Search filtering BEFORE pagination (in memory)
        if ($request->filled('search')) {
            $searchQuery = strtolower($request->input('search'));

            $allLogs = $allLogs->filter(function ($log) use ($searchQuery) {
                return stripos($log->activity, $searchQuery) !== false;
            });
        }

        // Manual pagination after filtering
        $page = $request->input('page', 1);
        $perPage = 7;

        $logs = new \Illuminate\Pagination\LengthAwarePaginator(
            $allLogs->forPage($page, $perPage),
            $allLogs->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        // AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('components.bhw.activity-log-table', [
                'logs' => $logs,
                'personnel' => $personnel
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => [
                    'current_page' => $logs->currentPage(),
                    'last_page' => $logs->lastPage(),
                    'per_page' => $logs->perPage(),
                    'total' => $logs->total(),
                    'from' => $logs->firstItem(),
                    'to' => $logs->lastItem(),
                    'links' => $logs->hasPages() ? $logs->links()->render() : '',
                ]
            ]);
        }

        // Regular page
        return view('midwife.BHWs-profile', [
            'personnel' => $personnel,
            'logs' => $logs
        ]);
    }


    public function getBHWs()
    {
        $user = Auth::user();
        $midwife = $user->midwife;

        if (!$midwife) {
            return response()->json([
                'success' => false,
                'message' => 'No midwife found for this user.'
            ], 404);
        }

        // Get personnel in the same barangay with role_id 3 or 4
        $bhws = Personnel::with('user') // include related user model
            ->where('brgy_id', $midwife->brgy_id)
            ->whereIn('role_id', [3, 4])
            ->where('status', 'active')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bhws
        ]);
    }

    public function store(Request $request)
    {        
        $validated = $request->validate([
            'firstName'   => 'required|string|max:50',
            'lastName'    => 'required|string|max:50',
            'middleName'  => 'nullable|string|max:50',
            'suffix'      => 'nullable|string|max:10',
            'birthdate'   => 'required|date_format:m/d/Y',
            'age'         => 'required|integer|min:0|max:150',
            'sex'         => 'required|in:Male,Female,Other',
            'email'       => 'required|email|max:100',
            'contactNo'   => 'required|string|min:7|max:20',
            'privilege'   => 'required|integer|in:3,4',
            'civilStatus' => 'required|in:Single,Married,Divorced,Widowed,Separated',
            'religion'    => 'required|string|max:100',
        ]);

        $mid = Auth::user();

        // get current logged-in midwife
        $midwifePersonnel = Midwife::where('user_id', Auth::id())
            ->where('role_id', 2)
            ->first();

        if (!$midwifePersonnel) {
            return response()->json([
                'success' => false,
                'message' => 'Midwife personnel record not found'
            ], 404);
        }

        $password = Str::random(8);
        $birthdate = Carbon::createFromFormat('m/d/Y', $validated['birthdate'])->format('Y-m-d');

        // create user account for BHW
        $user = User::create([
            'firstName'   => $validated['firstName'],
            'lastName'    => $validated['lastName'],
            'middleName'  => $validated['middleName'],
            'suffix'      => $validated['suffix'],
            'birthdate'   => $birthdate,
            'contact_no'  => $validated['contactNo'],
            'email'       => $validated['email'],
            'password'    => bcrypt($password),
            'role_id'     => $validated['privilege'],
            'civil_status' => $validated['civilStatus'],
            'religion' => $validated['religion'],
            'sex' => $validated['sex'],
        ]);

        // create personnel record for BHW
        $personnel = Personnel::create([
            'user_id' => $user->id,
            'role_id' => $validated['privilege'],
            'brgy_id' => $midwifePersonnel->brgy_id,
            'status'  => 'active',
        ]);

        // send email with credentials
        Mail::to($user->email)->send(new BHWCredentialsMail($user->email, $password));

       // Build the full name for logging
        $bhwName = $user->firstName;
        if ($user->middleName) {
            $bhwName .= ' ' . $user->middleName;
        }
        $bhwName .= ' ' . $user->lastName;
        if ($user->suffix) {
            $bhwName .= ' ' . $user->suffix;
        }

        // Log the activity
        $activityLog = ActivityLog::create([
            'user_id' => $mid->id,
            'module_id' => 9,
            'activity' => 'Added BHW: ' . $bhwName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'BHW created successfully and credentials emailed',
            'data' => [
                'user'      => $user,
                'personnel' => $personnel,
                // 'password' => $password // optional for testing only
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        
        $validated = $request->validate([
            'firstName'    => 'required|string|max:50',
            'lastName'     => 'required|string|max:50',
            'middleName'   => 'nullable|string|max:50',
            'suffix'       => 'nullable|string|max:10',
            'birthdate'    => 'nullable|date',
            'sex'          => 'nullable|string|max:10',
            'civil_status' => 'nullable|string|max:20',
            'religion'     => 'nullable|string|max:50',
            'email'        => 'required|email|unique:users,email,' . $id,
            'contact_no'   => 'nullable|string|max:20',
            'role_id'      => 'required|integer',
        ]);
        
        $user = User::findOrFail($id);

        $bhw = Personnel::where('user_id', $user->id)->first();

        if (!$bhw || $bhw->brgy_id !== auth()->user()->personnel->brgy_id) {
            abort(403, 'Unauthorized to update this personnel');
        }

        $user->update($validated);

        if ($bhw) {
            $bhw->update([
                'role_id' => $validated['role_id'],
            ]);
        }

        $bhwName = $user->firstName;
        if ($user->middleName) {
            $bhwName .= ' ' . $user->middleName;
        }
        $bhwName .= ' ' . $user->lastName;
        if ($user->suffix) {
            $bhwName .= ' ' . $user->suffix;
        }

        $mid = Auth::user();

        ActivityLog::create([
            'user_id' => $mid->id,
            'module_id' => 9,
            'activity' => 'Updated BHW: ' . $bhwName,
        ]);

        return response()->json([
            'message' => 'Payload received successfully',
        ]);
    }

    public function remove(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $bhw = Personnel::where('user_id', $user->id)->first();
        
        if (!$bhw || $bhw->brgy_id !== auth()->user()->personnel->brgy_id) {
            abort(403, 'Unauthorized to remove this personnel');
        }

        $user->update([
            'status' => 'inactive'
        ]);

        if ($bhw) {
            $bhw->update([
                'status' => 'inactive'
            ]);
        }

        // Build the bhwName for activity logging
        $bhwName = $user->firstName;
        if ($user->middleName) {
            $bhwName .= ' ' . $user->middleName;
        }
        $bhwName .= ' ' . $user->lastName;
        if ($user->suffix) {
            $bhwName .= ' ' . $user->suffix;
        }

        // Log the activity
        $mid = Auth::user();
        ActivityLog::create([
            'user_id' => $mid->id,
            'module_id' => 9,
            'activity' => 'Removed BHW: ' . $bhwName,
        ]);

        return response()->json([
            'message' => 'BHW removed successfully (set to inactive)',
            'user'    => $user,
            'bhw'     => $bhw
        ]);
    }

}
