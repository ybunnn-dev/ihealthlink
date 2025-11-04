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


class MidwifeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emptyBrgy = Barangay::whereDoesntHave('midwives')->get();

        // The query now includes latest() for sorting and paginate() for pagination.
        $midwivesPaginator = Midwife::with(['user', 'barangay'])
            ->where('status', 'active') 
            ->latest() // Orders by 'created_at' descending
            ->paginate(8);


        // Use through() to apply your mapping logic to the paginated collection.
        $rows = $midwivesPaginator->through(function ($m) {
            $user = $m->users ?? $m->user ?? null;
            $barangay = $m->barangay ?? $m->barangay ?? null;

            $parts = array_filter([
                $user->firstName ?? null,
                $user->middleName ?? null,
                $user->lastName ?? null,
                $user->suffix ?? null,
            ]);
            $fullName = $parts ? implode(' ', $parts) : ($user->name ?? 'N/A');

            return [
                'midwife_no'   => $m->id,
                'name'         => $fullName,
                'barangay'     => $barangay->name ?? 'N/A',
                'date_added'   => optional($m->created_at)->format('M d, Y'),
                'date_updated' => optional($m->updated_at)->format('M d, Y'),
            ];
        });

        return view('mho.midwives', [
            'midwives'   => $rows, // Pass the paginator with transformed items to the view.
            'emptyBrgy'  => $emptyBrgy,
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
            'barangayId' => 'required|integer|exists:barangay,id',
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
    /**
     * Display the specified resource.
     */
    public function show(string $name, string $m_id)
    {
        // 1. Find the midwife record using the unique ID ($m_id) from the URL.
        // The $name parameter is not needed for the query but must be in the signature.
        $midwife = Midwife::with(['user', 'barangay'])->findOrFail($m_id);
        $emptyBrgy = Barangay::whereDoesntHave('midwives')->get();

        // 2. Extract the related user and barangay objects for easier access.
        $user = $midwife->user;
        $barangay = $midwife->barangay;

        // 3. Consolidate all the required details into a single array.
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

        // 4. Return the view and pass the consolidated data.
       return view('mho.spec-midwife', [
            'midwife' => $data,
            'avail_brgy' => $emptyBrgy
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function search(Request $request)
    {
        // Get and Validate Query Parameters
        $searchQuery = $request->input('search');
        $sortBy = $request->input('sort_by', 'alphabetical'); // default alphabetical
        $dateFilter = $request->input('date_filter');

        \Log::info($searchQuery);

        $query = Midwife::query()->with(['users', 'barangay']);

        // --- Search ---
        $query->when($searchQuery, function ($q, $searchQuery) {
            $q->whereHas('users', function ($sub) use ($searchQuery) {
                $sub->where('firstName', 'like', "%{$searchQuery}%")
                    ->orWhere('lastName', 'like', "%{$searchQuery}%")
                    ->orWhere('middleName', 'like', "%{$searchQuery}%")
                    ->orWhere('suffix', 'like', "%{$searchQuery}%")
                    // Full name search
                    ->orWhereRaw("CONCAT_WS(' ', firstName, middleName, lastName, suffix) LIKE ?", ["%{$searchQuery}%"]);
            });
        });

        // --- Date Filter ---
        $query->when($dateFilter, function ($q, $dateFilter) {
            switch ($dateFilter) {
                case 'week': return $q->where('personnel.created_at', '>=', now()->subWeek());
                case 'month': return $q->where('personnel.created_at', '>=', now()->subMonth());
                case 'year': return $q->where('personnel.created_at', '>=', now()->subYear());
            }
        });

        // --- Sorting ---
        switch ($sortBy) {
            case 'age-asc':
                $query->join('users', 'personnel.user_id', '=', 'users.id')
                    ->select('personnel.*')
                    ->orderBy('users.birthdate', 'asc');
                break;

            case 'age-desc':
                $query->join('users', 'personnel.user_id', '=', 'users.id')
                    ->select('personnel.*')
                    ->orderBy('users.birthdate', 'desc');
                break;

            case 'alphabetical':
            default:
                $query->join('users', 'personnel.user_id', '=', 'users.id')
                    ->select('personnel.*')
                    ->orderBy('users.lastName', 'asc')
                    ->orderBy('users.firstName', 'asc');
                break;
        }

        // --- Paginate ---
        
        $midwives = $query->paginate(15)->withQueryString();
       
        return response()->json($midwives);
    }

    public function update(Request $request, $userId)
    {
        // Log payload for debugging
        Log::info("Received update for midwife ID {$request->midwife_id}", $request->all());

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
