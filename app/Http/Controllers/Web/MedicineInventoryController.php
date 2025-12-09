<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\MedicineInventory;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class MedicineInventoryController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            return response()->json([
                'result' => 'error',
                'message' => 'Unauthorized access.'
            ], 403);
        }
        
        try {
            $medicine = Medicine::findOrFail($id);

            if ($medicine->brgy_id !== $user->personnel->brgy_id) {
                abort(403, 'Unauthorized to view this medicine');
            }

            // Validate input
            $validated = $request->validate([
                'expiry_date'       => 'required|date|after:today',
                'quantity_received' => 'required|integer|min:1',
            ]);

            // Auto-generate batch number (increment per medicine)
            $latestBatch = MedicineInventory::where('medicine_id', $medicine->id)
                ->orderBy('batch_num', 'desc')
                ->first();

            $nextBatchNum = $latestBatch ? $latestBatch->batch_num + 1 : 1;

            // Create inventory record
            $inventory = MedicineInventory::create([
                'medicine_id'       => $medicine->id,
                'added_by'          => Auth::id(),
                'batch_num'         => $nextBatchNum,
                'stock'             => $validated['quantity_received'],
                'date_received'     => now()->toDateString(),
                'quantity_received' => $validated['quantity_received'],
                'expiry_date'       => $validated['expiry_date'],
            ]);

            // Log the activity
            ActivityLog::create([
                'user_id' => $user->id,
                'module_id' => 1, // Update this to your medicines module ID
                'activity' => 'Added new batch #' . $nextBatchNum . ' for "' . $medicine->medicine_name . '" with quantity of ' . $validated['quantity_received'] . '.',
            ]);

            return response()->json([
                'result' => 'success',
                'message' => 'New batch added successfully.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'result' => 'error',
                'message' => 'Validation failed: ' . implode(', ', $e->errors())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateExpiry(Request $request, MedicineInventory $inventory)
    {
        $user = auth()->user();

        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            return response()->json([
                'result' => 'error',
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $request->validate([
            'expiry_date' => 'required|date|after:today'
        ]);
        
        $inventory->update([
            'expiry_date' => $request->expiry_date
        ]);

        $medicine = $inventory->medicine;

        // Log the activity
        ActivityLog::create([
            'user_id' => $user->id,
            'module_id' => 1, // Update this to your medicines module ID
            'activity' => 'Updated expiry date for batch #' . $inventory->id . ' for "' . $medicine->medicine_name . '.',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Expiry date updated successfully'
        ]);
    }
    public function deactivate($id)
    {
        $user = auth()->user();

        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            return response()->json([
                'result' => 'error',
                'message' => 'Unauthorized access.'
            ], 403);
        }
        try {
            $inventory = MedicineInventory::findOrFail($id);
            
            // Optional: Add authorization check
            // $this->authorize('delete', $inventory);
            
            // Check if batch can be deactivated (no stock used)
            $stockUsed = $inventory->initial_quantity - $inventory->quantity;
            
            if ($stockUsed > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot deactivate batch: stock has already been used.'
                ], 422);
            }

            $medicine = $inventory->medicine;

            // Log the activity
            ActivityLog::create([
                'user_id' => $user->id,
                'module_id' => 1, // Update this to your medicines module ID
                'activity' => 'Removed batch #' . $inventory->id . ' for "' . $medicine->medicine_name . '.',
            ]);

            // Set status to inactive
            $inventory->status = 'inactive';
            $inventory->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Batch has been successfully deactivated.'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error deactivating inventory batch: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deactivating the batch.'
            ], 500);
        }
    }
}