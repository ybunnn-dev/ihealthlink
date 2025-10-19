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
use App\Models\HouseholdResidenceHistory;
use App\Models\ActivityLog;
use Illuminate\Validation\Rule;


class HouseholdController extends Controller
{
   public function index()
    {
        $user = Auth::user();

        $personnel = $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

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
        $user = Auth::user();

        // Identify which type of personnel is logged in
        $personnel = $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        // Get barangay with its puroks
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);

        if (!$barangay) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barangay not found for this personnel.'
            ], 404);
        }

        $brgyId = $barangay->id;

        // Merge metadata
        $request->merge([
            'added_by' => $user->id,
            'brgy_id' => $brgyId,
        ]);

        $validated = $request->validate([
            'purok_id' => [
                'required',
                Rule::exists('puroks', 'id')->where(function ($query) use ($brgyId) {
                    $query->where('brgy_id', $brgyId);
                }),
            ],
            'water_source'   => 'nullable|string|max:255',
            'sanitary'       => 'required|string|max:255',
            'waste_disposal' => 'required|string|max:255',
            'added_by'       => 'required|exists:users,id',
            'brgy_id'        => 'required|exists:barangays,id',
        ]);

        // Create household
        $household = Household::create([
            'purok_id'        => $validated['purok_id'],
            'head_id'         => null, // will be assigned later
            'sanitary_toilet' => $validated['sanitary'],
            'water_source'    => $validated['water_source'],
            'waste_disposal'  => $validated['waste_disposal'],
            'status'          => 'active',
        ]);

        // Create household residence history
        $history = HouseholdResidenceHistory::create([
            'household_id'         => $household->id,
            'head_id'              => null,
            'purok_id'             => $validated['purok_id'],
            'water_source'         => $validated['water_source'],
            'waste_disposal'       => $validated['waste_disposal'],
            'sanitary_toilet'      => $validated['sanitary'],
            'status'               => 'active',
        ]);

        // Get purok name for logging
        $purok = Purok::find($validated['purok_id']);

        // Log the activity
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 5, // replace with correct module ID for households
            'activity'  => 'Added a new household in Purok ' . ucfirst($purok->name) . '.',
        ]);

        return response()->json([
            'message'   => 'Household created successfully!',
            'household' => $household,
            'history'   => $history,
        ], 201);
    }


    public function show(Household $household)
    {
        $user = Auth::user();

        $personnel = $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $household = $household->load(['purok', 'families']); 

        \Log::info($household);
        
        return view('midwife.spec-household', [
            'household' => $household,
            'purok'     => $household->purok,
            'families'  => $household->families,
        ]);
    }

    
    public function getHouseholdsJson(Request $request)
    {
        $user = Auth::user();

        $personnel = $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

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
