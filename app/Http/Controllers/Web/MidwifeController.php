<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\MidwifeCredentialsMail;


use App\Models\Midwife;
use App\Models\Barangay;
use App\Models\User;
use App\Models\Personnel;
use App\Models\ActivityLog;


class MidwifeController extends Controller
{
   public function index(Request $request)
    {
        $searchQuery = $request->input('search');
        $filterBy = $request->input('filter_by', 'filter-alphabetical');
        $dateFilter = $request->input('date_filter');

        // Base query — ensure only midwives are loaded
        $query = Midwife::query()
            ->with(['user', 'barangay'])
            ->where('personnel.role_id', 2) // midwife only
            ->where('personnel.status', 'active');

        // --- Date Filter ---
        $query->when($dateFilter, function ($q, $dateFilter) {
            switch ($dateFilter) {
                case 'week':
                    return $q->where('personnel.created_at', '>=', now()->subWeek());
                case 'month':
                    return $q->where('personnel.created_at', '>=', now()->subMonth());
                case 'year':
                    return $q->where('personnel.created_at', '>=', now()->subYear());
            }
        });

        // --- Sorting ---
        switch ($filterBy) {
            case 'filter-age-asc':
                $query->join('users', 'personnel.user_id', '=', 'users.id')
                    ->select('personnel.*')
                    ->orderBy('users.birthdate', 'asc');
                break;

            case 'filter-age-desc':
                $query->join('users', 'personnel.user_id', '=', 'users.id')
                    ->select('personnel.*')
                    ->orderBy('users.birthdate', 'desc');
                break;

            default:
                $query->join('users', 'personnel.user_id', '=', 'users.id')
                    ->select('personnel.*')
                    ->orderBy('users.lastName', 'asc')
                    ->orderBy('users.firstName', 'asc');
        }

        // --- Fetch ALL results before search + pagination ---
        $allMidwives = $query->get();


        // --- SEARCH FIRST ---
        if ($searchQuery) {
            $searchLower = strtolower($searchQuery);

            $allMidwives = $allMidwives->filter(function ($midwife) use ($searchLower) {
                $user = $midwife->user;
                if (!$user) return false;

                $fullName = strtolower(trim(implode(' ', array_filter([
                    $user->firstName,
                    $user->middleName,
                    $user->lastName,
                    $user->suffix
                ]))));

                return str_contains($fullName, $searchLower);
            })->values();
        }


        // --- PAGINATE AFTER SEARCH ---
        $page = $request->input('page', 1);
        $perPage = 8;

        $midwives = new \Illuminate\Pagination\LengthAwarePaginator(
            $allMidwives->forPage($page, $perPage),
            $allMidwives->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );


        // AJAX response
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data' => $midwives->items(),
                'links' => $midwives->links()->render()
            ]);
        }


        // Barangays with no active midwives
        $emptyBrgy = Barangay::whereDoesntHave('midwives', function ($q) {
            $q->where('status', 'active')->where('role_id', 2);
        })->get();


        return view('mho.midwives', [
            'midwives' => $midwives,
            'emptyBrgy' => $emptyBrgy,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'middleName' => 'nullable|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'birthdate' => 'required|date',
            'age' => 'required|integer|min:18|max:100',
            'sex' => 'required|string|in:Male,Female,Other',
            'civilStatus' => 'required|string|in:Single,Married,Divorced,Widowed',
            'religion' => 'required|string|max:50',
            'contactNo' => 'required|string|max:20',
            'barangayId' => 'required|integer|exists:barangays,id',
            'email' => 'required|email|unique:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Log the received payload
        Log::info('Midwife creation payload received:', $request->all());

        $validated = $validator->validated();
        
        $password = Str::random(8);
        $birthdate = Carbon::createFromFormat('m/d/Y', $request->birthdate)->format('Y-m-d');

        // Create the user
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'middleName' => $request->middleName,
            'suffix' => $request->suffix,
            'birthdate' => $birthdate,
            'contact_no' => $request->contactNo,
            'email' => $request->email,
            'password' => bcrypt($password),
            'role_id' => 2,
            'civil_status' => $validated['civilStatus'],
            'religion' => $validated['religion'],
            'sex' => $validated['sex'],
        ]);

        // Create personnel (midwife) record
        $personnel = Midwife::create([
            'user_id' => $user->id,
            'role_id' => 2, // midwife role
            'brgy_id' => $request->barangayId,
            'status' => 'active',
        ]);

        // Send email with credentials
        Mail::to($user->email)->send(new MidwifeCredentialsMail($user->email, $password));

        return response()->json([
            'success' => true,
            'message' => 'Midwife created successfully and credentials emailed',
            'data' => [
                'user' => $user,
                'personnel' => $personnel,
                //'password' => $password // optional, remove for production
            ]
        ], 201);
    }
    
    public function show(Request $request, string $name, string $m_id)
    {
        // Find the midwife record using the unique ID ($m_id) from the URL
        $midwife = Midwife::with(['user', 'barangay'])->findOrFail($m_id);
        $emptyBrgy = Barangay::whereDoesntHave('midwives', function ($q) {
            $q->where('status', 'active')
            ->where('role_id', 2);
        })->get();

        // Extract the related user and barangay objects for easier access
        $user = $midwife->user;
        $barangay = $midwife->barangay;

        // Consolidate all the required details into a single array
        $data = [
            // Personnel Details from the Midwife model
            'midwife_id'    => $midwife->id,
            'status'        => ucfirst($midwife->status),
            'date_added'    => $midwife->created_at->format('F d, Y h:i A'),

            // Personal Information from the User model
            'user_id'       => $user->id,
            'firstName'     => $user->firstName,
            'lastName'      => $user->lastName,
            'middleName'    => $user->middleName,
            'suffix'        => $user->suffix,
            'fullName'      => trim("{$user->firstName} {$user->middleName} {$user->lastName} {$user->suffix}"),
            'email'         => $user->email,
            'contact_no'    => $user->contact_no,
            'birthdate'     => Carbon::parse($user->birthdate)->format('F d, Y'),
            'age'           => Carbon::parse($user->birthdate)->age,
            'sex'           => $user->sex,
            'civil_status'  => $user->civil_status,
            'religion'      => $user->religion,

            // Assignment Details from the Barangay model
            'barangay_id'   => $barangay->id,
            'barangay_name' => $barangay->name,
        ];

        // Query for activity logs filtered by module_id 6 and 9
        $query = ActivityLog::where('user_id', $user->id)
            ->whereIn('module_id', [6, 9]);

        // Date Filters
        $dateFilter = $request->input('date_filter');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if ($dateFilter) {
            switch ($dateFilter) {
                case 'last_week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'last_month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'custom':
                    if ($fromDate && $toDate) {
                        $query->whereBetween('created_at', [$fromDate, $toDate]);
                    }
                    break;
            }
        }

        // Fetch all matching logs (before pagination for encrypted search)
        $allLogs = $query->latest()->get();

        // Search filter on decrypted activity (in memory)
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->input('search'));

            $allLogs = $allLogs->filter(function ($log) use ($searchTerm) {
                return stripos($log->activity, $searchTerm) !== false;
            });
        }

        // Manual pagination after filtering
        $page = $request->input('page', 1);
        $perPage = 8;

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

        // AJAX request: return partial HTML for logs + pagination meta
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('components.midwife.activity-log-table', [
                'logs' => $logs,
                'midwife' => $data,
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
                ],
            ]);
        }

        // Regular page load
        return view('mho.spec-midwife', [
            'midwife' => $data,
            'avail_brgy' => $emptyBrgy,
            'logs' => $logs,
        ]);
    }

    public function update(Request $request, $userId)
    {
        // Log payload for debuggin

        // Update the User model
        $user = User::find($userId);
        if ($user) {
            $user->update([
                'firstName'     => $request->firstName,
                'lastName'      => $request->lastName,
                'middleName'    => $request->middleName,
                'suffix'        => $request->suffix,
                'birthdate'     => $request->birthdate,
                'contact_no'    => $request->contact_no,
                'email'         => $request->email,
                'sex'           => $request->sex,
                'civil_status'  => $request->civil_status,
                'religion'      => $request->religion,
            ]);
        }

        // Update the Midwife model
        $midwife = Midwife::find($request->midwife_id);
        if ($midwife) {
            $midwife->update([
                'brgy_id'    => $request->brgy_id,
                'status'     => $request->status ?? $midwife->status,
                // 'added_by' or other fields can be updated if needed
            ]);
        }

        // Return a response
        return response()->json([
            'status' => 'success',
            'message' => 'Midwife updated successfully',
            'user' => $user,
            'midwife' => $midwife
        ]);
    }

    public function remove(Request $request, $userId)
    {
        // Find the user
        $user = User::find($request->user_id);
        if ($user) {
            $user->status = 'inactive';
            $user->save();
        }

        // Find the midwife
        $midwife = Midwife::where('user_id', $request->user_id)->first();
        if ($midwife) {
            $midwife->status = 'inactive';
            $midwife->save();
        }

        // log for debugging
        Log::info('Midwife removal set to inactive for user_id: ' . $request->user_id, [
            'user_status' => $user?->status,
            'midwife_status' => $midwife?->status
        ]);

        // 4Return response
        return response()->json([
            'status' => 'success',
            'message' => 'Midwife and user status set to inactive',
            'user' => $user,
            'midwife' => $midwife
        ]);
    }

}
