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
 public function index(Request $request)
    {
        // Get current user's personnel info
        $user = Auth::user();

        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } elseif ($user->bhw && $user->bhw->role_id == 3) { // fixed bhwWeb -> bhw
            $personnel = $user->bhw;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        // Find barangay and its puroks
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay?->puroks ?? collect();

        // Get all households in the barangay's puroks
        $purokIds = $puroks->pluck('id');
        $householdIds = Household::whereIn('purok_id', $purokIds)->pluck('id');

        // Base query
        $familiesQuery = Family::with(['household.purok.barangay', 'residents'])
            ->withCount('residents')
            ->whereIn('household_id', $householdIds);

        // Search only among families that have residents matching the search
        if ($request->filled('search')) {
            $search = $request->search;

            $familiesQuery->whereHas('residents', function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                ->orWhere('middleName', 'like', "%{$search}%")
                ->orWhere('lastName', 'like', "%{$search}%");
            });
        }

        //  Optional filter by purok
        if ($request->filled('purok_id')) {
            $purokId = $request->purok_id;
            $familiesQuery->whereHas('household', function ($q) use ($purokId) {
                $q->where('purok_id', $purokId);
            });
        }

        // Get the results
        $families = $familiesQuery->paginate(2);

        return response()->json([
            'families' => $families,
            'puroks' => $puroks,
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
