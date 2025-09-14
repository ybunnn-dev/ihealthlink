<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Household;
use App\Models\Barangay;
use App\Models\Family;

class HouseholdController extends Controller
{
   public function index()
    {
        $personnel = Auth::user()->midwife;

        // Get barangay with its puroks
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        // Get households under those puroks
        $purokIds = $puroks->pluck('id');
        $households = Household::whereIn('purok_id', $purokIds)->get();

        return view('midwife.household-list', [
            'households' => $households, //this is the one that will be used to fill that table
            'puroks'     => $puroks,
        ]);
    }
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'purok_id'     => 'required|exists:puroks,id',
            'water_source' => 'nullable|string|max:255',
            'sanitary'     => 'required|in:1,2', // 1 = yes, 2 = no
        ]);

        // Convert sanitary (1 = true, 2 = false)
        $hasToilet = $validated['sanitary'] === '1';

        // Create household
        $household = Household::create([
            'purok_id'     => $validated['purok_id'],
            'head_id'      => null, // will be set later
            'has_toilet'   => $hasToilet,
            'water_source' => $validated['water_source'],
            'status'       => 'active',
        ]);

        return response()->json([
            'result' => 'success',
            'message'   => 'Household created successfully',
            'household' => $household,
        ]);
    }

    public function show(Household $id)
    {
        $household = $id;
        $household->load(['purok', 'families']); // also eager load families
        return view('midwife.spec-household', [
            'household' => $household,
            'purok' => $household->purok,
            'families' => $household->families,
        ]);
    }

}
