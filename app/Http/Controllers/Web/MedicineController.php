<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Medicine;


class MedicineController extends Controller
{
    // Show all medicines
    public function index()
    {
        $midwife = Auth::user()->midwife;

        // Get medicines only for the midwife's barangay
        $medicines = Medicine::with(['inventories'])
            ->where('brgy_id', $midwife->brgy_id)
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

        return view('midwife.medicine-list', [
            'medicines' => $medicinesWithStock
        ]);
    }

    public function show($id) // Show specific medicine details
    {
        $medicine = Medicine::with(['inventories.addedBy'])->findOrFail($id);

        return view('midwife.spec-medicine', [
            'medicine'    => $medicine,
            'inventories' => $medicine->inventories
        ]);
    }

    // Store a new medicine
    public function store(Request $request)
    {
        // 1. Get the authenticated user
        $user = Auth::user();

        // 2. Find the user's barangay ID through their midwife profile
        //    We use optional() to prevent errors if the relationships don't exist.
        $brgyId = $user->midwife->brgy_id;

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
    public function delete($id, Request $request)
    {
        $medicine = Medicine::find($id);

        if (!$medicine) {
            return response()->json([
                'result' => 'error',
                'message' => 'Medicine not found'
            ], 404);
        }

        // Update status to inactive
        $medicine->status = 'inactive';
        $medicine->save();

        return response()->json([
            'result' => 'success',
            'message' => 'Medicine marked as inactive',
            'id' => $medicine->id
        ]);
    }
}
