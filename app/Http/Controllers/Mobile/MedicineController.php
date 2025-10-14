<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Medicine;
use App\Models\ActivityLog;

class MedicineController extends Controller
{
   public function index(Request $request)
    {
        $user = Auth::user();

        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $barangayId = $personnel->brgy_id;

        // Get query params
        $search = $request->query('search');
        $category = $request->query('category');

        // Base query: medicines belonging to the personnel's barangay and active
        $query = Medicine::with(['inventories'])
            ->where('brgy_id', $barangayId)
            ->where('status', 'active');

        // Apply search filter
       if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $lowerSearch = strtolower($search);
                $q->whereRaw('LOWER(medicine_name) LIKE ?', ['%' . $lowerSearch . '%'])
                ->orWhereRaw('LOWER(generic_name) LIKE ?', ['%' . $lowerSearch . '%']);
            });
        }

        // Apply category filter
        if (!empty($category)) {
            $query->where('category', $category);
        }

        // Sort by latest (you can change to 'asc' if needed)
        $medicines = $query->orderBy('id', 'desc')->get();

        // Compute remaining stock (only non-expired)
        $medicinesWithStock = $medicines->map(function ($medicine) {
            $remainingStock = $medicine->inventories
                ->filter(fn($inventory) => \Carbon\Carbon::parse($inventory->expiry_date)->isFuture())
                ->sum('stock');

            $medicine->remaining_stock = $remainingStock;
            return $medicine;
        });

        return response()->json([
            'status' => 'success',
            'medicines' => $medicinesWithStock
        ]);
    }


    private function normalizeCategory($category)
    {
        $map = [
            'reg-med' => 'Regular Medicine',
            'deworming' => 'Deworming Tablet',
            'iron-w-fa' => 'Iron with Folic Acid',
            'iron' => 'Iron',
            'vit-a' => 'Vitamin A',
            'cc' => 'Calcium Carbonate',
            'iodine' => 'Iodine Capsule',
        ];

        return $map[strtolower($category)] ?? ucfirst($category);
    }

    private function normalizeForm($form)
    {
        $map = [
            'tablet' => 'Tablet',
            'capsule' => 'Capsule',
            'syrup' => 'Syrup',
            'vaccine' => 'Vaccine',
            'iron' => 'Iron',
            'non-medicine' => 'Non-Medicine',
        ];

        return $map[strtolower($form)] ?? ucfirst($form);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $brgyId = $personnel->brgy_id;

        $request->merge([
            'added_by' => $user->id,
            'brgy_id' => $brgyId,
        ]);

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

        // Normalize category and form
        $validatedData['category'] = $this->normalizeCategory(strtolower($validatedData['category']));
        $validatedData['form'] = $this->normalizeForm(strtolower($validatedData['form']));

        // Create new medicine
        $medicine = Medicine::create($validatedData);

        // Log the activity
        ActivityLog::create([
            'user_id' => $user->id,
            'module_id' => 8, // Use correct module ID for Medicines
            'activity' => 'Added new medicine "' . ucfirst($medicine->medicine_name) . '" to the inventory.',
        ]);

        return response()->json([
            'message' => 'Medicine added successfully!',
            'medicine' => $medicine
        ], 201);
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
    public function show($id) 
    {
        $medicine = Medicine::with(['inventories.addedBy'])->findOrFail($id);

        return response()->json([
            'medicine'    => $medicine,
            'inventories' => $medicine->inventories
        ]);
    }
}
