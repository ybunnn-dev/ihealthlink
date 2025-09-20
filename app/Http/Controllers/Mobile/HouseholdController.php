<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Household;
use App\Models\Barangay;
use App\Models\Family;
use App\Models\Purok;

class HouseholdController extends Controller
{
    public function index()
    {
        $personnel = Auth::user()->bhw;

        // Get barangay with its puroks
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        // Get households under those puroks + families
        $purokIds = $puroks->pluck('id');
        $households = Household::with('families')
            ->whereIn('purok_id', $purokIds)
            ->get();

        return response()->json([
            'households' => $households,
            'puroks'     => $puroks,
        ]);
    }
}
