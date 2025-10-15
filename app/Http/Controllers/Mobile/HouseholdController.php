<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Household;
use App\Models\Barangay;
use App\Models\Family;
use App\Models\Purok;
use App\Models\ActivityLog;
use App\Models\HouseholdResidenceHistory;
use Illuminate\Validation\Rule;


class HouseholdController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        // Get barangay with its puroks
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        // Get households under those puroks + families
        $purokIds = $puroks->pluck('id');
        
        $query = Household::with([
                'families',
                'purok.barangay',
                'head'
            ])
            ->whereIn('purok_id', $purokIds);

        // Apply purok filter if provided
        if ($request->filled('purok_id')) {
            $query->where('purok_id', $request->purok_id);
        }

        // Get all households first (before search)
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            
            // Get all households and filter in memory due to encrypted fields
            $allHouseholds = $query->get();
            
            $filteredHouseholds = $allHouseholds->filter(function ($household) use ($searchTerm) {
                if (!$household->head) {
                    return false;
                }
                
                $firstName = strtolower($household->head->firstName ?? '');
                $lastName = strtolower($household->head->lastName ?? '');
                $middleName = strtolower($household->head->middleName ?? '');
                
                return str_contains($firstName, $searchTerm) ||
                    str_contains($lastName, $searchTerm) ||
                    str_contains($middleName, $searchTerm);
            });
            
            // Manual pagination
            $page = $request->get('page', 1);
            $perPage = 20;
            $offset = ($page - 1) * $perPage;
            
            $paginatedData = $filteredHouseholds->slice($offset, $perPage)->values();
            
            $households = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedData,
                $filteredHouseholds->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $households = $query->paginate(20);
        }
            
        return response()->json([
            'households' => $households,
        ]);
    }

    
    public function show(Household $household)
    {
        $user = Auth::user();

        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $household = $household->load(['purok.barangay', 'families']); 

        \Log::info($household);
        
        return response()->json([
            'household' => $household,
            'purok'     => $household->purok,
            'families'  => $household->families,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Identify which type of personnel is logged in
        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

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


}
