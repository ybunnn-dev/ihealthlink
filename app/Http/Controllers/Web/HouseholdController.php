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
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class HouseholdController extends Controller
{
    public function index(Request $request)
    {
        
        $user = Auth::user();
        $personnel = $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;
        $purokIds = $puroks->pluck('id');

        // Fetch all relevant households
        $households = Household::with(['head', 'families.residents'])
            ->whereIn('purok_id', $purokIds)
            ->get();

        // Apply purok filter
        if ($request->filled('purok_id')) {
            $households = $households->where('purok_id', $request->purok_id);
        }

        // Apply search filter (PHP-level, after decryption)
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);

            $households = $households->filter(function ($household) use ($searchTerm) {
                // Search in household head
                $head = $household->head;
                if ($head) {
                    $headName = strtolower(trim("{$head->firstName} {$head->middleName} {$head->lastName}"));
                    if (str_contains($headName, $searchTerm)) return true;
                }

                // Search among residents
                foreach ($household->families as $family) {
                    foreach ($family->residents as $resident) {
                        $residentName = strtolower(trim("{$resident->firstName} {$resident->middleName} {$resident->lastName}"));
                        if (str_contains($residentName, $searchTerm)) return true;
                    }
                }

                return false;
            });
        }

        // Manual pagination since we're filtering in collection
        $perPage = 7;
        $page = $request->get('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $households->forPage($page, $perPage),
            $households->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        // AJAX response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'html' => view('components.household.household-table-rows', ['households' => $paginated])->render(),
                'pagination' => view('components.household.pagination', ['households' => $paginated])->render(),
            ]);
        }

        // Regular view
        return view('midwife.household-list', [
            'households' => $paginated,
            'puroks' => $puroks,
        ]);
    }

    public function update(Request $request){
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
            'updated_by' => $user->id,
            'brgy_id' => $brgyId,
        ]);

        $validated = $request->validate([
            'household_id' => 'required|exists:households,id',
            'purok_id' => [
                'required',
                Rule::exists('puroks', 'id')->where(function ($query) use ($brgyId) {
                    $query->where('brgy_id', $brgyId);
                }),
            ],
            'water_source'   => 'nullable|string|max:255',
            'sanitary'       => 'required|string|max:255',
            'waste_disposal' => 'required|string|max:255',
            'updated_by'     => 'required|exists:users,id',
            'brgy_id'        => 'required|exists:barangays,id',
        ]);

        // Find the household to update
        $household = Household::find($validated['household_id']);

        // Authorization: Ensure medicine belongs to the same barangay
        if ($household->purok->brgy_id !== $user->personnel->brgy_id) {
            abort(403, 'Unauthorized to view this household');
        }
        
        if (!$household) {
            return response()->json([
                'status' => 'error',
                'message' => 'Household not found.'
            ], 404);
        }

        // Find the most recent active history record and set it to inactive

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
            'purok_id'        => $household->purok_id,
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
            'activity'  => 'Updated household details in ' . ucfirst($purok->name) . '.',
        ]);

        return response()->json([
            'result'  => 'success',
            'message'   => 'Household updated successfully!',
            'household' => $household,
            'history'   => $history,
        ], 200);
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

        // Create household with UUID
        $household = Household::create([
            'client_uuid'     => Str::uuid()->toString(),  // ← Add UUID for sync
            'purok_id'        => $validated['purok_id'],
            'head_id'         => null, // will be assigned later
            'sanitary_toilet' => $validated['sanitary'],
            'water_source'    => $validated['water_source'],
            'waste_disposal'  => $validated['waste_disposal'],
            'status'          => 'active',
        ]);

        // Create household residence history
        $history = HouseholdResidenceHistory::create([
            'household_id'    => $household->id,
            'head_id'         => null,
            'purok_id'        => $validated['purok_id'],
            'water_source'    => $validated['water_source'],
            'waste_disposal'  => $validated['waste_disposal'],
            'sanitary_toilet' => $validated['sanitary'],
            'status'          => 'active',
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
            'result'  => 'success',
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

        // Authorization: Ensure medicine belongs to the same barangay
        if ($household->purok->brgy_id !== $user->personnel->brgy_id) {
            abort(403, 'Unauthorized to view this household');
        }
        // Load related data: purok, head, families (with residents + active residents count)
        $household = $household->load([
            'purok',
            'head',
            'families' => function ($query) {
                $query->with([
                    'residents' => function ($resQuery) {
                        // Optional: filter or order residents if needed
                        $resQuery->orderBy('lastName');
                    },
                ])->withCount([
                    'residents' => function ($countQuery) {
                        $countQuery->where('status', 'active');
                    },
                ]);
            },
        ])->loadCount('families');

        

        return view('midwife.spec-household', [
            'household' => $household,
            'purok' => $household->purok,
            'families' => $household->families,
            'familiesCount' => $household->families_count,
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

        $purokIds = $puroks->pluck('id');
        
        // Load all households with relationships (no filters at query level due to encryption)
        $households = Household::whereIn('purok_id', $purokIds)
            ->with(['head', 'families', 'purok'])
            ->get();

        // Apply purok filter in memory (since purok name is encrypted)
        if ($request->filled('purok')) {
            $purokName = $request->input('purok');
            
            $households = $households->filter(function ($household) use ($purokName) {
                // Auto-decrypted by model
                return $household->purok && $household->purok->name === $purokName;
            })->values();
        }

        // Apply search filter in memory (since names are encrypted)
        if ($request->filled('search')) {
            $searchQuery = strtolower($request->input('search'));
            
            $households = $households->filter(function ($household) use ($searchQuery) {
                // Search by household ID number
                if (stripos($household->id_number, $searchQuery) !== false) {
                    return true;
                }
                
                // Search by head name (auto-decrypted by model)
                if ($household->head) {
                    $fullName = strtolower($household->head->firstName . ' ' . $household->head->lastName);
                    if (stripos($fullName, $searchQuery) !== false) {
                        return true;
                    }
                }
                
                return false;
            })->values();
        }

        // Format the data
        $formattedHouseholds = $households->map(function ($household) {
            return [
                'id'           => $household->id,
                'head_name'    => $household->head ? $household->head->firstName . ' ' . $household->head->lastName : 'N/A',
                'member_count' => $household->families->count(),
                'purok'        => $household->purok->name, // Auto-decrypted
            ];
        });

        // Return JSON response
        return response()->json([
            'households' => $formattedHouseholds
        ]);
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
        
        if ($household->purok->brgy_id !== $user->personnel->brgy_id) {
            abort(403, 'Unauthorized to view this household');
        }

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
}
