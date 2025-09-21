<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Medicine;
use App\Models\MedicineInventory;

class MedicineInventoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicine_id'       => 'required|exists:medicines,id',
            'expiry_date'       => 'required|date|after:today',
            'quantity_received' => 'required|integer|min:1',
        ]);

        // Find the medicine
        $medicine = Medicine::findOrFail($validated['medicine_id']);

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
            'stock'             => $validated['quantity_received'], // stock = qty
            'date_received'     => now()->toDateString(),           // same as date_added
            'quantity_received' => $validated['quantity_received'],
            'expiry_date'       => $validated['expiry_date'],
        ]);

        return response()->json([
            'result'    => 'success',
            'message'   => 'New batch added successfully.',
            'medicine'  => $medicine->only(['id', 'name']),
            'inventory' => $inventory,
        ]);
    }
}
