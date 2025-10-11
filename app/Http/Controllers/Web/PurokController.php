<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

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
        $puroks = Purok::where('brgy_id', $barangay->id)
            ->where('status', 'active')
            ->get();

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $newName = $request->input('name');

        // Find purok by ID
        $purok = Purok::findOrFail($id);

        // Check if another purok in the same barangay already has this name
        $exists = Purok::where('brgy_id', $purok->brgy_id)
            ->where('name', $newName)
            ->where('id', '!=', $id) // exclude current purok
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => "A purok with the name '{$newName}' already exists in this barangay.",
                'status' => 'error',
            ], 422);
        }

        // Update purok name
        $purok->update([
            'name' => $newName,
        ]);

        return response()->json([
            'message' => 'Purok updated successfully!',
            'purok_id' => $purok->id,
            'new_name' => $purok->name,
            'status' => 'success',
        ], 200);
    }
    public function remove($id)
    {
        $purok = \App\Models\Purok::findOrFail($id);

        // Update status to 'removed'
        $purok->update([
            'status' => 'inactive'
        ]);

        \Log::info(" Purok ID {$id} marked as removed (status updated)");

        return response()->json([
            'message' => 'Purok status updated to removed successfully!',
            'purok_id' => $purok->id,
            'status' => $purok->status,
        ], 200);
    }
    public function getPuroks(){
        $user = Auth::user();

        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        }  else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay?->puroks ?? collect();

        return response()->json([
            'puroks' => $puroks
        ]);
        
    }
}
