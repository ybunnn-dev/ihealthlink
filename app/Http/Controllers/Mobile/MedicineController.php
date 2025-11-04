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

        \Log::info($category);

        if (!empty($category)) {
            $query->where('category', $category);
        }


        // Sort by latest and paginate
        $medicines = $query->orderBy('id', 'desc')->paginate(20);

        // Use through() to compute remaining stock while maintaining pagination
        $medicines->through(function ($medicine) {
            $remainingStock = $medicine->inventories
                ->filter(fn($inventory) => \Carbon\Carbon::parse($inventory->expiry_date)->isFuture())
                ->sum('stock');

            $medicine->remaining_stock = $remainingStock;
            return $medicine;
        });

        return response()->json([
            'status' => 'success',
            'medicines' => $medicines
        ]);
    }


    private function normalizeCategory($category)
    {
        // Map FROM display names TO shortcodes
        $map = [
            'regular medicine' => 'reg-med',
            'deworming tablet' => 'deworming',
            'iron with folic acid' => 'iron-w-fa',
            'iron' => 'iron',
            'vitamin a' => 'vit-a',
            'calcium carbonate' => 'cc',
            'iodine capsule' => 'iodine',
            'vaccine' => 'vaccine'
        ];

        $lowercased = strtolower($category);
        return $map[$lowercased] ?? strtolower($category);
    }

    private function normalizeForm($form)
    {
        // Map FROM display names TO shortcodes/standardized form
        $map = [
            'tablet' => 'tablet',
            'capsule' => 'capsule',
            'syrup' => 'syrup',
            'vaccine' => 'vaccine',
            'iron' => 'iron',
            'non-medicine' => 'non-medicine',
        ];

        $lowercased = strtolower($form);
        return $map[$lowercased] ?? strtolower($form);
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
        $user = Auth::user();

        // Validate input
        $validated = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'generic_name'  => 'nullable|string|max:255',
            'category'      => 'required|string|max:255',
            'form'          => 'required|string|max:255',
            'description'   => 'nullable|string',
        ]);

        // Find the medicine by ID
        $medicine = Medicine::findOrFail($id);

        $validated['category'] = $this->normalizeCategory(strtolower($validated['category']));
        $validated['form'] = $this->normalizeForm(strtolower($validated['form']));

        // Update with validated data
        $medicine->update($validated);

        // Log the activity
        ActivityLog::create([
            'user_id' => $user->id,
            'module_id' => 8, // Same module ID as your store method
            'activity' => 'Updated medicine "' . ucfirst($medicine->medicine_name) . '" in the inventory.',
        ]);

        return response()->json([
            'result' => 'success',
            'message'  => 'Medicine updated successfully',
            'medicine' => $medicine
        ]);
    }


    private function denormalizeCategory($category)
    {
        // Map FROM shortcodes TO display names
        $map = [
            'reg-med' => 'Regular Medicine',
            'deworming' => 'Deworming Tablet',
            'iron-w-fa' => 'Iron with Folic Acid',
            'iron' => 'Iron',
            'vit-a' => 'Vitamin A',
            'cc' => 'Calcium Carbonate',
            'iodine' => 'Iodine Capsule',
            'vaccine' => 'Vaccine'
        ];

        return $map[strtolower($category)] ?? ucfirst($category);
    }

    private function denormalizeForm($form)
    {
        // Map FROM shortcodes TO display names
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

    public function show($id) // Show specific medicine details
    {
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else if($user->bhw){
            $personnel = $user->bhw;
        }
        else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }
        
        $medicine = Medicine::with(['inventories.addedBy'])->findOrFail($id);

        // ✅ Convert shortcodes to display names
        $medicine->category = $this->denormalizeCategory($medicine->category);
        $medicine->form = $this->denormalizeForm($medicine->form);

        return response()->json([
            'medicine'    => $medicine,
            'inventories' => $medicine->inventories
        ]);
    }

    public function getMedicines()
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
