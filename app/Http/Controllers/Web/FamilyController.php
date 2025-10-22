<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Barangay;
use App\Models\Household;
use App\Models\Family;
use App\Models\Resident;

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
        $families = Family::with('household.purok')
        ->whereIn('household_id', $householdIds)
        ->paginate(7); 
        
        return view('midwife.families', [
            'families' => $families
        ]);
    }

    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'household_id' => 'required|integer|exists:households,id',
            'is4ps'        => 'required|string|in:Yes,No',
            'isIndigent'   => 'required|string|in:Yes,No',
            'isIwasGutom' => 'required|string|in:Yes,No',
        ]);

        // Convert "Yes"/"No" to booleans
        $is4ps = $validated['is4ps'] === 'Yes';
        $isIndigent = $validated['isIndigent'] === 'Yes';
        $isIwasGutom = $validated['isIwasGutom'] === 'Yes';

        // Save to database
        $family = Family::create([
            'household_id' => $validated['household_id'],
            'status'       => 'active',
            'is_indigent'  => $isIndigent,
            'is_4ps'       => $is4ps,
            'is_iwas_gutom' => $isIwasGutom,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Family successfully added',
            'data'    => $family
        ]);
    }
   public function show(Family $family)
    {
        // Eager load household + purok + residents
        $family->load(['household.purok', 'residents']);

        $residentCount = $family->residents->count(); // collection count

        return view('midwife.spec-family', [
            'family' => $family,
            'purok'  => $family->household->purok,
            'residentCount' => $residentCount,
        ]);
    }

    public function getFamilies(Request $request)
    {
        // Get the current user's personnel info
        $personnel = Auth::user()->midwife;

        // Find the barangay and the puroks that the user manages
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        // Get the households that belong to the puroks of that barangay
        $purokIds = $puroks->pluck('id');

        $query = Family::with([
            'household.purok.barangay',
            'residents' // Include residents for searching and displaying
        ])
        ->whereHas('household', function ($q) use ($purokIds) {
            $q->whereIn('purok_id', $purokIds);
        });

        // Apply Purok filter
        if ($request->filled('purok_id')) {
            $purokId = $request->input('purok_id');
            $query->whereHas('household', function ($q) use ($purokId) {
                $q->where('purok_id', $purokId);
            });
        }

        // Apply Search filter (by resident name)
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->whereHas('residents', function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                ->orWhere('middleName', 'like', "%{$search}%")
                ->orWhere('lastName', 'like', "%{$search}%");
            });
        }

        // Get families
        $families = $query->get();

        // Attach purok info to each family (optional for clarity)
        $families->each(function ($family) {
            $family->purok = $family->household->purok ?? null;
        });

        // Proper JSON response
        return response()->json([
            'families' => $families,
            'puroks' => $puroks,
        ]);
    }
}
