<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\MedicineInventory;
use Illuminate\Support\Facades\Auth;

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
            abort(403, 'Unauthorized access.');
        }
        
        $medicine = Medicine::findOrFail($id);

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
        MedicineInventory::create([
            'medicine_id'       => $medicine->id,
            'added_by'          => Auth::id(),
            'batch_num'         => $nextBatchNum,
            'stock'             => $validated['quantity_received'], // stock = qty
            'date_received'     => now()->toDateString(),           // same as date_added
            'quantity_received' => $validated['quantity_received'],
            'expiry_date'       => $validated['expiry_date'],
        ]);

        return redirect()
            ->route('midwife.medicines.show', $medicine->id)
            ->with('success', 'New batch added successfully.');
    }

}