<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Medicine;

class MedicineController extends Controller
{
    public function index()
    {
        $personnel = Auth::user()->bhw;

        // Get medicines only for the personnel's barangay
        $medicines = Medicine::with(['inventories'])
            ->where('brgy_id', $personnel->brgy_id)
            ->where('status', 'active')
            ->orderBy('id', 'asc')
            ->get();

        // Map each medicine to include remaining non-expired stock
        $medicinesWithStock = $medicines->map(function ($medicine) {
            $remainingStock = $medicine->inventories
                ->filter(fn($inventory) => Carbon::parse($inventory->expiry_date)->isFuture())
                ->sum('stock');

            $medicine->remaining_stock = $remainingStock;
            return $medicine;
        });

        return response()->json([
            'medicines' => $medicinesWithStock
        ]);
    }

    public function store(Request $request)
    {
        // 1. Get the authenticated user
        $user = Auth::user();

        $brgyId = $user->bhw->brgy_id;

        // Abort if the user is not associated with a barangay
        if (!$brgyId) {
            return response()->json(['message' => 'User is not associated with a barangay.'], 403); // 403 Forbidden
        }

        // 3. Merge the user's ID and barangay ID into the request data
        $request->merge([
            'added_by' => $user->id,
            'brgy_id' => $brgyId,
        ]);

        // 4. Validate the incoming data
        //    The unique rule now checks that the medicine_name is unique *per barangay*.
        $validatedData = $request->validate([
            'medicine_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('medicines')->where(function ($query) use ($brgyId) {
                    return $query->where('brgy_id', $brgyId);
                }),
            ],
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string',
            'form' => 'required|string',
            'description' => 'nullable|string',
            'added_by' => 'required|exists:users,id',
            'brgy_id' => 'required|exists:barangays,id',
        ]);

        // 5. Create a new Medicine record
        $medicine = Medicine::create($validatedData);

        // 6. Return a success response as JSON
        return response()->json([
            'message' => 'Medicine added successfully!',
            'medicine' => $medicine
        ], 201); // 201 Created
    }
    public function updateMedicine(Request $request, $id)
    {
        // Validate input (optional but good practice)
        $validated = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'generic_name'  => 'nullable|string|max:255',
            'category'      => 'required|string|max:255',
            'form'          => 'required|string|max:255',
            'description'   => 'nullable|string',
        ]);

        // Find the medicine by ID
        $medicine = Medicine::findOrFail($id);

        // Update with validated data
        $medicine->update($validated);

        return response()->json([
            'result' => 'success',
            'message'  => 'Medicine updated successfully',
            'medicine' => $medicine
        ]);
    }
}
