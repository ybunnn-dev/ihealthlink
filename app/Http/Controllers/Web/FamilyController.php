<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Family;
use App\Models\Barangay;
use App\Models\Household;

class FamilyController extends Controller
{
    public function index(){
        //get the current user's personnel info
        $personnel = Auth::user()->midwife;

        //find the barangay and the puroks that the user manages
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        //get the households that belongs to the puroks of that barangay
        $purokIds = $puroks->pluck('id');
        $households = Household::whereIn('purok_id', $purokIds)->get();

        //get the families
        $householdIds = $households->pluck('id');
        $families = Family::whereIn('household_id', $householdIds)->get();  
        
        return view('midwife.families', [
            'families' => $families
        ]);
    }

    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'household_id' => 'required|integer|exists:households,id',
            'familyHeadId' => 'nullable|integer|exists:residents,id',
            'is4ps'        => 'required|string|in:Yes,No',
            'isIndigent'   => 'required|string|in:Yes,No',
        ]);

        // Convert "Yes"/"No" to booleans
        $is4ps = $validated['is4ps'] === 'Yes';
        $isIndigent = $validated['isIndigent'] === 'Yes';

        // Save to database
        $family = Family::create([
            'household_id' => $validated['household_id'],
            'head_id'      => $validated['familyHeadId'],
            'status'       => 'active',
            'is_indigent'  => $isIndigent,
            'is_4ps'       => $is4ps,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Family successfully added',
            'data'    => $family
        ]);
    }
}
