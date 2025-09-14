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
}
