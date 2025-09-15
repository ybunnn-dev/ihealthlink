<?php

namespace App\Http\Controllers\Mobile;

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

}
