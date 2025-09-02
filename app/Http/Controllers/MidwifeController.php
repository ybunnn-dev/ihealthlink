<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

        
        $midwives = Midwife::with(['users', 'barangays'])
            ->where('role_id', 2)
            ->get();

        // Re-organize into table-friendly rows
        $rows = $midwives->map(function ($m) {
            $user = $m->users ?? $m->user ?? null;
            $barangay = $m->barangays ?? $m->barangay ?? null;

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
            'midwives'   => $rows,
            'emptyBrgy'  => $emptyBrgy,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        // Generate a random password
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
        ]);

        // Create personnel record
        $personnel = Midwife::create([
            'user_id' => $user->id,
            'role_id' => 2, // midwife role
            'brgy_id' => $request->barangayId,
            'status' => 'active',
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Midwife created successfully (password not emailed yet)',
            'data' => [
                'user' => $user,
                'personnel' => $personnel,
                'password' => $password // for testing only; remove before production
            ]
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show()
    {
       
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
