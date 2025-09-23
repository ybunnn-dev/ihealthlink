<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Barangay;
use App\Models\Household;
use App\Models\Family;

class FamilyController extends Controller
{
   public function index(){
        //get the current user's personnel info
        $personnel = Auth::user()->bhw;

        //find the barangay and the puroks that the user manages
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        //get the households that belongs to the puroks of that barangay
        $purokIds = $puroks->pluck('id');
        $households = Household::whereIn('purok_id', $purokIds)->get();

        //get the families + residents count
        $householdIds = $households->pluck('id');
        
        $families = Family::with('household.purok.barangay')
            ->withCount('residents') // <-- counts residents for each family
            ->whereIn('household_id', $householdIds)
            ->get();

        return response()->json([
            'families' => $families,
        ]);
    }
    public function show(Family $family)
    {
        // Eager load household + purok + residents
        $family->load(['household.purok.barangay', 'residents']);

        $residentCount = $family->residents->count(); // collection count


        return response()->json([
            'family' => $family,
            'residentCount' => $residentCount,
        ]);
    }

}
