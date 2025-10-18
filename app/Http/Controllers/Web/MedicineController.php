<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Medicine;
use App\Models\ActivityLog;
use App\Models\Midwife;

class MedicineController extends Controller
{
    // Show all medicines
    public function index()
    {
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $brgyId = $personnel->brgy_id;
        $perPage = 8; // Items per page

        // Fetch medicines with remaining non-expired stock calculated in the query
        $medicines = Medicine::with(['inventories' => function($q) {
                $q->where('expiry_date', '>', now());
            }])
            ->where('brgy_id', $brgyId)
            ->where('status', 'active')
            ->withSum(['inventories as remaining_stock' => function($q){
                $q->where('expiry_date', '>', now());
            }], 'stock')
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return view('midwife.medicine-list', [
            'medicines' => $medicines
        ]);
    }

    public function show($id) // Show specific medicine details
    {
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }
        $medicine = Medicine::with(['inventories.addedBy'])->findOrFail($id);

        return view('midwife.spec-medicine', [
            'medicine'    => $medicine,
            'inventories' => $medicine->inventories
        ]);
    }

    // Store a new medicine
    public function store(Request $request)
    {
        $user = auth()->user();

        // Determine if user is Midwife or BHW with granted access
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $brgyId = $personnel->brgy_id;

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
        
         ActivityLog::create([
            'user_id' => $user->id,
            'module_id' => 1, // change this based on your module mapping (e.g., 8 for medicines)
            'activity' => 'Added new medicine "' . $medicine->medicine_name . '" to the inventory.',
        ]);
        // 6. Return a success response as JSON
        return response()->json([
            'message' => 'Medicine added successfully!',
            'medicine' => $medicine
        ], 201); // 201 Created
    }
    public function updateMedicine(Request $request, $id)
    {
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }
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
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }
        
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


    public function getMedicines()
    {
        $user = auth()->user();

        // Determine personnel (Midwife or BHW)
        $personnel = $user->bhwWeb && $user->bhwWeb->role_id == 4
            ? $user->bhwWeb
            : $user->midwife;

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $brgyId = $personnel->brgy_id;

        if (!$brgyId) {
            return response()->json(['message' => 'User is not associated with a barangay.'], 403);
        }

        // Fetch medicines only for this barangay
        $medicines = Medicine::with(['inventories'])
            ->where('brgy_id', $brgyId)
            ->where('status', 'active')
            ->orderBy('id', 'asc')
            ->get();

        // Set threshold (2 months from now)
        $thresholdDate = Carbon::now()->addMonths(2);

        $medicinesWithStock = $medicines->map(function ($medicine) use ($thresholdDate) {
            $remainingStock = $medicine->inventories
                ->filter(function ($inventory) use ($thresholdDate) {
                    // Only include stocks expiring more than 2 months from now
                    return Carbon::parse($inventory->expiry_date)->greaterThan($thresholdDate);
                })
                ->sum('stock');

            // Add computed stock count
            $medicine->remaining_stock = $remainingStock;

            // Remove inventories to reduce payload
            unset($medicine->inventories);

            return $medicine;
        })
        // Only include medicines that still have stock
        ->filter(function ($medicine) {
            return $medicine->remaining_stock > 0;
        })
        // Reset array keys
        ->values();

        return response()->json($medicinesWithStock);
    }

}
