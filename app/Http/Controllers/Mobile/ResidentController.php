<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Resident;
use App\Models\HealthSigns;
use App\Models\ResidentMedicalHistory;
use App\Models\ResidentFamilyHistory;
use App\Models\Family;
use App\Models\Household;
use App\Models\Barangay;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ResidentController extends Controller
{
    public function index()
    {
        $personnel = Auth::user()->bhw;

        // Find the barangay and the puroks that the user manages
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        // Get the households that belong to the puroks of that barangay
        $purokIds = $puroks->pluck('id');
        $households = Household::whereIn('purok_id', $purokIds)->get();

        // Get the families
        $householdIds = $households->pluck('id');
        $families = Family::with('household.purok')
            ->whereIn('household_id', $householdIds)
            ->get();

        // Get the residents
        $familyIds = $families->pluck('id');
        $residents = Resident::with('family.household.purok')
            ->whereIn('family_id', $familyIds)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $residents
        ]);
    }


    public function show(Resident $resident){

        $resident->load([
            'family.household.purok',
            'healthSigns',
            'medicalHistory',
            'familyHistory',
            'ncdRiskFactor',
            'riskAssessment',
        ]);

        return response()->json([
            'success' => true,
            'resident' => $resident
        ]);
    }
}
