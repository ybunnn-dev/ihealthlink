<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use App\Models\Household;
use App\Models\Barangay;
use App\Models\Family;
use App\Models\Purok;

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
            'is_indigent'  => 'required|in:1,2',
            'waste_disposal' => 'required|string|max:255'
        ]);

        // Convert sanitary (1 = true, 2 = false)
        $hasToilet = $validated['sanitary'] === 1;
        $isIndigent = $validated['is_indigent'] === 1;

         $encryptedWaterSource = $validated['water_source']
            ? Crypt::encryptString($validated['water_source'])
            : null;

        // Create household
        $household = Household::create([
            'purok_id'     => $validated['purok_id'],
            'head_id'      => null, // will be set later
            'has_toilet'   => $hasToilet,
            'water_source' => $encryptedWaterSource,
            'is_indigent' => $isIndigent,
            'waste_disposal' => $validated['waste_disposal'],
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
        $household = $id->load(['purok', 'families']); 

        // decrypt here
        if ($household->water_source) {
            $household->water_source = Crypt::decryptString($household->water_source);
        }

        return view('midwife.spec-household', [
            'household' => $household,
            'purok'     => $household->purok,
            'families'  => $household->families,
        ]);
    }
    
    public function getHouseholdsJson(Request $request)
    {
        $personnel = Auth::user()->midwife;

        // Get barangay with its puroks
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        $purokIds = $puroks->pluck('id'); // gives you an array/collection of purok IDs
        $query = Household::whereIn('purok_id', $purokIds);
 
        \Log::info(json_encode($query));


        // 2. Apply search filter if provided
        if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $query->where(function ($q) use ($searchQuery) {
                // Search by household ID number
                $q->where('id_number', 'like', "%{$searchQuery}%")
                  // Also search by the household head's name (requires a relationship)
                  ->orWhereHas('head', function ($subQ) use ($searchQuery) {
                      $subQ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$searchQuery}%");
                  });
            });
        }

        // 3. Apply purok filter if provided
        if ($request->filled('purok')) {
            $purokName = $request->input('purok');
            $query->whereHas('purok', function ($q) use ($purokName) {
                $q->where('purok_name', $purokName); // Assuming your purok table has a 'purok_name' column
            });
        }

        // 4. Eager load relationships to prevent N+1 issues and get necessary data
        $households = $query->with(['head', 'families', 'purok'])->get();

        // 5. Format the data to match what the frontend expects
        $formattedHouseholds = $households->map(function ($household) {
            return [
                'id'           => $household->id, // The actual ID for the checkbox value
                'head_name'    => $household->head ? $household->head->first_name . ' ' . $household->head->last_name : 'N/A',
                'member_count' => $household->families->count(), // Count of families can represent members
                'purok'        => $household->purok->name,
            ];
        });

        // 6. Return the final data as a JSON response
        return response()->json([
            'households' => $formattedHouseholds
        ]);
    }

}
