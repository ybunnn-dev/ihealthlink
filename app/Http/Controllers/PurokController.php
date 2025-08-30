<?php

namespace App\Http\Controllers;

use App\Models\Purok;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PurokController extends Controller
{
    public function index()
    {
        return Purok::with('barangay')->get();
    }

    public function getByBarangay(Barangay $barangay)
    {
        $puroks = Purok::where('brgy_id', $barangay->id)->get();

        $puroks->transform(function ($purok) {
            $purok->households_count = rand(10, 50);
            $purok->residents_count  = rand(50, 300);
            return $purok;
        });

        return $puroks;
    }
    public function addPurok(Request $request)
    {
        // --- 1. Validate the incoming request ---
        // This ensures the 'name' and 'barangay_id' are present and valid.
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                // This rule ensures the purok name is unique within the specified barangay.
                Rule::unique('puroks')->where(function ($query) use ($request) {
                    return $query->where('brgy_id', $request->barangay_id);
                }),
            ],
            'barangay_id' => 'required|exists:barangays,id', // Checks if the barangay exists
        ]);

        // If validation fails, return a 422 error with the validation messages.
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // --- 2. Create the new Purok ---
            // 'purok' is a reserved keyword in PHP, so we use a different variable name.
            $newPurok = Purok::create([
                'name'    => $request->input('name'),
                'brgy_id' => $request->input('barangay_id'), // Map from payload to the correct DB column
                'user_id' => Auth::id(), // Automatically get the logged-in user's ID
                'status'  => 'active', // Set a default status
            ]);

            // --- 3. Return a successful response ---
            // The format matches what your JavaScript expects on success.
            return response()->json([
                'message' => 'Purok "' . $newPurok->name . '" has been added successfully!',
                'purok'   => $newPurok // Send back the newly created purok object
            ], 201); // Use 201 "Created" HTTP status code

        } catch (\Exception $e) {
            // In case of a database error or other server issue.
            return response()->json([
                'message' => 'An error occurred while saving the purok.'
            ], 500);
        }
    }
    
}
