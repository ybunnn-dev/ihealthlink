<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Medicine;


class MedicineController extends Controller
{
    // Show all medicines
    public function index()
    {
        // Get all medicines
        $medicines = Medicine::with(['inventories'])->orderBy('id', 'asc')->get();

        // Map each medicine to include remaining non-expired stock
        $medicinesWithStock = $medicines->map(function ($medicine) {
            $remainingStock = $medicine->inventories
                ->filter(function ($inventory) {
                    // Only include non-expired items
                    return Carbon::parse($inventory->expiry_date)->isFuture();
                })
                ->sum('stock'); // sum up stock of non-expired inventories

            $medicine->remaining_stock = $remainingStock; // attach remaining stock to medicine
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
        $validated = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category'     => 'required|string|max:255',
            'form'         => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);

        Medicine::create([
            'added_by'      => Auth::id(), // logged-in user
            'medicine_name' => $validated['medicine_name'],
            'generic_name'  => $validated['generic_name'],
            'category'      => $validated['category'],
            'form'          => $validated['form'],
            'description'   => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Medicine added successfully!');
    }
}
