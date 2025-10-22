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
use Illuminate\Support\Facades\DB;
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
        }; 

        $household = $household->load(['purok.barangay', 'families', 'head'])
                            ->loadCount('families'); 
        
        return response()->json([
            'household' => $household,
            'purok'     => $household->purok,
            'families'  => $household->families,
        ]);
    }

    public function storeOrUpdateHouseholdSyc(Request $request){
        //here
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

   public function update(Request $request){
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
            'updated_by' => $user->id,
            'brgy_id' => $brgyId,
        ]);

        $validated = $request->validate([
            'household_id' => 'required|exists:households,id',
            'water_source'   => 'nullable|string|max:255',
            'sanitary'       => 'required|string|max:255',
            'waste_disposal' => 'required|string|max:255',
            'updated_by'     => 'required|exists:users,id',
            'brgy_id'        => 'required|exists:barangays,id',
        ]);

        // Find the household to update
        $household = Household::find($validated['household_id']);

        if (!$household) {
            return response()->json([
                'status' => 'error',
                'message' => 'Household not found.'
            ], 404);
        }

        // Find the most recent active history record and set it to inactive
        $previousHistory = HouseholdResidenceHistory::where('household_id', $household->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($previousHistory) {
            $previousHistory->update(['status' => 'inactive']);
        }

        // Update household
        $household->update([
            'sanitary_toilet' => $validated['sanitary'],
            'water_source'    => $validated['water_source'],
            'waste_disposal'  => $validated['waste_disposal'],
            'status'          => 'active',
        ]);

        // Refresh the household to get updated values
        $household->refresh();

        // Create new household residence history using the updated household data
        $history = HouseholdResidenceHistory::create([
            'household_id'         => $household->id,
            'head_id'              => $household->head_id,
            'purok_id'             => $household->purok_id,
            'water_source'         => $household->water_source,
            'waste_disposal'       => $household->waste_disposal,
            'sanitary_toilet'      => $household->sanitary_toilet,
            'status'               => 'active',
        ]);

        // Get purok name for logging
        $purok = Purok::find($household->purok_id);

        // Log the activity
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 5, // replace with correct module ID for households
            'activity'  => 'Updated household details in Purok ' . ucfirst($purok->name) . '.',
        ]);

        return response()->json([
            'message'   => 'Household updated successfully!',
            'household' => $household,
            'history'   => $history,
        ], 200);
    }

    public function householdGet(Request $request)
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

        // Validate the household_id parameter
        $request->validate([
            'household_id' => 'required|integer'
        ]);

        $householdId = $request->household_id;

        // Find household with families and their active residents
        $household = Household::whereHas('families.residents', function ($query) {
            $query->where('status', 'active');
        })
        ->with([
            'families' => function ($query) {
                $query->with(['residents' => function ($residentQuery) {
                    $residentQuery->where('status', 'active')
                                ->select('id', 'family_id', 'firstName', 'middleName', 'lastName', 'suffix', 'status');
                }]);
            }
        ])
        ->find($householdId);

        if (!$household) {
            return response()->json([
                'message' => 'Household not found or has no active residents'
            ], 404);
        }

        // Build residents array with full names
        // The model will automatically decrypt the name fields
        $residents = [];
        
        foreach ($household->families as $family) {
            foreach ($family->residents as $resident) {
                // Since names are encrypted, Laravel's model will auto-decrypt them
                // when you access them as properties
                $nameParts = array_filter([
                    $resident->prefix,      // Auto-decrypted
                    $resident->firstName,   // Auto-decrypted
                    $resident->middleName,  // Auto-decrypted
                    $resident->lastName     // Auto-decrypted
                ]);
                
                $residents[] = [
                    'id' => 'server_' . $resident->id,
                    'full_name' => implode(' ', $nameParts),
                    'family_id' => $family->id,
                ];
            }
        }

        return response()->json([
            'household_id' => $household->id,
            'total_residents' => count($residents),
            'residents' => $residents
        ], 200);
    }


    public function setHead(Request $request)
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

        \Log::info($request['household_id']);
        \Log::info($request['head_id']);

        $household = Household::find($request['household_id']);

        if (!$household) {
            return response()->json([
                'success' => false,
                'message' => 'Household not found.'
            ], 404);
        }

        $household->update([
            'head_id' => $request['head_id']
        ]);

        // Log the activity
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 5, // replace with correct module ID for households
            'activity'  => 'Updated Household #' . $household->id . '.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Household head updated successfully.',
            'household' => $household
        ], 200);
    }

    public function storeOrUpdateHouseholdSync(Request $request)
    {
        $user = Auth::user();
        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);

        if (!$barangay) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barangay not found for this personnel.'
            ], 404);
        }

        $validated = $request->validate([
            'households' => 'required|array',
            'households.*.local_id' => 'required|integer',
            'households.*.client_uuid' => 'required|string',
            'households.*.purok_server_id' => 'required|exists:puroks,id',
            'households.*.water_source' => 'nullable|string|max:255',
            'households.*.sanitary_toilet' => 'required|string|max:255',
            'households.*.waste_disposal' => 'required|string|max:255',
            'households.*.is_iwas_gutom_enrolled' => 'nullable|integer',
            'households.*.is_indigent' => 'nullable|integer',
            'households.*.status' => 'required|string',
            'households.*.updated_at' => 'required|string',
        ]);

        $syncedHouseholds = [];

        DB::transaction(function () use ($validated, $user, $barangay, &$syncedHouseholds) {
            $householdsToUpsert = [];

            foreach ($validated['households'] as $householdData) {
                // Check if household exists by client_uuid
                $existingHousehold = Household::where('client_uuid', $householdData['client_uuid'])->first();

                // Last Write Wins conflict resolution
                if ($existingHousehold) {
                    $serverUpdatedAt = Carbon::parse($existingHousehold->updated_at);
                    $clientUpdatedAt = Carbon::parse($householdData['updated_at']);

                    // Skip if server has newer data
                    if ($serverUpdatedAt->greaterThan($clientUpdatedAt)) {
                        $syncedHouseholds[] = [
                            'local_id' => $householdData['local_id'],
                            'server_id' => $existingHousehold->id,
                            'updated_at' => $existingHousehold->updated_at->toIso8601String(),
                        ];
                        continue;
                    }
                }

                $householdsToUpsert[] = [
                    'client_uuid' => $householdData['client_uuid'],
                    'purok_id' => $householdData['purok_server_id'],
                    'water_source' => $householdData['water_source'],
                    'waste_disposal' => $householdData['waste_disposal'],
                    'sanitary_toilet' => $householdData['sanitary_toilet'],
                    'is_iwas_gutom_enrolled' => $householdData['is_iwas_gutom_enrolled'] ?? 0,
                    'is_indigent' => $householdData['is_indigent'] ?? 0,
                    'status' => $householdData['status'],
                    'updated_at' => $householdData['updated_at'],
                    'created_at' => now(),
                ];
            }

            // Perform bulk upsert
            if (!empty($householdsToUpsert)) {
                Household::upsert(
                    $householdsToUpsert,
                    ['client_uuid'], // Unique constraint
                    ['purok_id', 'water_source', 'waste_disposal', 'sanitary_toilet', 
                    'is_iwas_gutom_enrolled', 'is_indigent', 'status', 'updated_at'] // Columns to update
                );
            }

            // Retrieve server IDs and map to local IDs
            foreach ($validated['households'] as $householdData) {
                $household = Household::where('client_uuid', $householdData['client_uuid'])->first();

                if ($household) {
                    $syncedHouseholds[] = [
                        'local_id' => $householdData['local_id'],
                        'server_id' => $household->id,
                        'updated_at' => $household->updated_at->toIso8601String(),
                    ];

                    // Create history record
                    HouseholdResidenceHistory::create([
                        'household_id' => $household->id,
                        'head_id' => $household->head_id,
                        'purok_id' => $household->purok_id,
                        'water_source' => $household->water_source,
                        'waste_disposal' => $household->waste_disposal,
                        'sanitary_toilet' => $household->sanitary_toilet,
                        'status' => 'active',
                    ]);

                    // Log activity
                    $purok = Purok::find($household->purok_id);
                    ActivityLog::create([
                        'user_id' => $user->id,
                        'module_id' => 5,
                        'activity' => 'Synced household in Purok ' . ucfirst($purok->name) . '.',
                    ]);
                }
            }
        });

        return response()->json([
            'message' => 'Households synced successfully!',
            'households' => $syncedHouseholds,
        ], 200);
    }

}
