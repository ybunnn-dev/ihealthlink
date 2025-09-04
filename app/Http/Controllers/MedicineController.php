<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{
    // Show all medicines
    public function index()
    {
        $medicines = Medicine::orderBy('id', 'asc')->get();

        return view('midwife.medicine-list', compact('medicines'));
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
