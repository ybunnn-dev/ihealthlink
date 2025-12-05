<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use App\Models\Barangay;
use App\Models\Household;
use App\Models\Family;
use App\Models\FamilyResidenceHistory;
use App\Models\Resident;
use App\Models\ResidenceHistory;
use App\Models\ActivityLog;
use App\Models\Purok;

class FamilyController extends Controller
{  
    public function index(Request $request)
    {
        // Get the current user's personnel info
        $user = Auth::user();

        // Determine personnel type
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }


        // Find the barangay and the puroks that the user manages
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        // Get the purok IDs
        $purokIds = $puroks->pluck('id');

        // Build the query
        $query = Family::with(['household.purok'])
            ->withCount([
                'residents as active_residents_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->whereHas('household', function($q) use ($purokIds) {
                $q->whereIn('purok_id', $purokIds);
            });

        // Apply purok filter (can be done at DB level)
        if ($request->filled('purok_id')) {
            $query->whereHas('household', function($q) use ($request) {
                $q->where('purok_id', $request->purok_id);
            });
        }

        // Apply date sorting
        if ($request->filled('date_sort')) {
            $dateSort = $request->date_sort;
            
            switch ($dateSort) {
                case 'Last Week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'Month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'Last Year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
                // 'Custom' would need additional date range parameters
            }
            
            $query->orderBy('created_at', 'desc');
        } else {
            // Default sort by newest first
            $query->orderBy('created_at', 'desc');
        }

        // Check if we need to filter in memory (search only, since names might be encrypted)
        $needsMemoryFiltering = $request->filled('search');

        if ($needsMemoryFiltering) {
            // Get all families for in-memory filtering
            $allFamilies = $query->get();

            // Apply search filter (search through family members)
            if ($request->filled('search')) {
                $searchTerm = strtolower($request->search);
                $allFamilies = $allFamilies->filter(function($family) use ($searchTerm) {
                    // Search by family ID
                    if (str_contains((string)$family->id, $searchTerm)) {
                        return true;
                    }
                    
                    // Search by household purok name
                    $purokName = strtolower($family->household->purok->name ?? '');
                    if (str_contains($purokName, $searchTerm)) {
                        return true;
                    }
                    
                    // Search through family members (if residents are loaded)
                    if ($family->relationLoaded('residents')) {
                        foreach ($family->residents as $resident) {
                            $fullName = strtolower(trim($resident->firstName . ' ' . ($resident->middleName ?? '') . ' ' . $resident->lastName));
                            if (str_contains($fullName, $searchTerm)) {
                                return true;
                            }
                        }
                    }
                    
                    return false;
                });
            }

            // Manually paginate
            $page = $request->get('page', 1);
            $perPage = 7;
            $total = $allFamilies->count();
            $results = $allFamilies->forPage($page, $perPage);
            
            $families = new \Illuminate\Pagination\LengthAwarePaginator(
                $results, 
                $total, 
                $perPage, 
                $page, 
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            // No memory filtering needed, use database pagination
            $families = $query->paginate(7);
        }

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'html' => view('components.family.table-rows', compact('families'))->render(),
                'pagination' => view('components.family.pagination', compact('families'))->render(),
            ]);
        }

        // Return full view for initial page load
        return view('midwife.families', [
            'families' => $families,
            'puroks' => $puroks,
        ]);
    }



    public function store(Request $request)
    {
        $user = Auth::user();

        // Determine personnel type (Midwife or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else{
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. No associated personnel found.'
            ], 403);
        }

        // Get barangay to verify household belongs to this personnel's barangay
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);

        if (!$barangay) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barangay not found for this personnel.'
            ], 404);
        }

        // Validate inputs
        $validated = $request->validate([
            'household_id' => [
                'required',
                'integer',
                'exists:households,id',
                // Ensure household belongs to this barangay
                Rule::exists('households', 'id')->whereIn('purok_id', function ($query) use ($barangay) {
                    $query->select('id')
                        ->from('puroks')
                        ->where('brgy_id', $barangay->id);
                }),
            ],
            'is4ps'        => 'required|string|in:Yes,No',
            'isIndigent'   => 'required|string|in:Yes,No',
            'isIwasGutom'  => 'required|string|in:Yes,No',
        ]);

        // Convert "Yes"/"No" to booleans
        $is4ps = $validated['is4ps'] === 'Yes';
        $isIndigent = $validated['isIndigent'] === 'Yes';
        $isIwasGutom = $validated['isIwasGutom'] === 'Yes';

        // Get the parent household
        $household = Household::findOrFail($validated['household_id']);

        if ($household->purok->brgy_id !== $user->personnel->brgy_id) {
            abort(403, 'Unauthorized to view this family');
        }
        // Create the family record with UUID
        $family = Family::create([
            'client_uuid'   => Str::uuid()->toString(),  // Generate UUID for sync
            'household_id'  => $household->id,
            'status'        => 'active',
            'is_indigent'   => $isIndigent,
            'is_4ps'        => $is4ps,
            'is_iwas_gutom' => $isIwasGutom,
        ]);

        // Create a residence history record
        FamilyResidenceHistory::create([
            'family_id'     => $family->id,
            'purok_id'      => $household->purok_id,  // Get from parent household
            'is_indigent'   => $isIndigent,
            'is_4ps'        => $is4ps,
            'is_iwas_gutom' => $isIwasGutom,
            'status'        => 'active',
        ]);

        // Get the purok name for activity log
        $purok = $household->purok;

        // Log the activity
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 4,  // Family module
            'activity'  => 'Added a new family in Purok ' . ucfirst($purok->name) . '.',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Family successfully added',
            'data'    => $family,
        ], 201);
    }

   public function show(Family $family)
    {
        $user = Auth::user();

        // Authorization: Ensure medicine belongs to the same barangay
        if ($family->household->purok->brgy_id !== $user->personnel->brgy_id) {
            abort(403, 'Unauthorized to view this family');
        }
        // Eager load household + purok + residents
        $family->load(['household.purok.barangay', 'residents']);

        $residentCount = $family->residents->count(); // collection count

        return view('midwife.spec-family', [
            'family' => $family,
            'purok'  => $family->household->purok,
            'residentCount' => $residentCount,
        ]);
    }

    public function getFamilies(Request $request)
    {
        $user = Auth::user();

        // Determine personnel type (Midwife or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else{
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. No associated personnel found.'
            ], 403);
        }

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

        if ($request->filled('search')) {
            $search = strtolower(trim($request->input('search')));
            
            // Get all families first, then filter in PHP since fields are encrypted
            $allFamilies = $query->get();
            
            $filteredFamilies = $allFamilies->filter(function ($family) use ($search) {
                return $family->residents->some(function ($resident) use ($search) {
                    $fullName = trim(
                        ($resident->firstName ?? '') . ' ' . 
                        ($resident->middleName ?? '') . ' ' . 
                        ($resident->lastName ?? '')
                    );
                    
                    return stripos($fullName, $search) !== false;
                });
            });

            // Take first 20 results
            $families = $filteredFamilies->take(20)->values();
        } else {
            // Get first 20 families when no search
            $families = $query->take(20)->get();
        }

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

   public function transfer(Request $request) {
    
    $user = Auth::user();

    if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
        $personnel = $user->bhwWeb;
    } else {
        $personnel = $user->midwife;
    }

    if (!$personnel) {
        abort(403, 'Unauthorized access.');
    }
    
    $validated = $request->validate([
        'family_id' => 'required|integer|exists:families,id',
        'household_id' => 'required|integer|exists:households,id',
    ]);
    
    $familyId = $validated['family_id'];
    $newHouseholdId = $validated['household_id'];
    
    try {
        DB::beginTransaction();
        
        
        $family = Family::with('household')->findOrFail($familyId);
        \Log::info('BEFORE UPDATE - Family state:', [
            'family_id' => $family->id,
            'current_household_id' => $family->household_id,
            'target_household_id' => $newHouseholdId,
            'table_check' => DB::table('families')->find($familyId),
        ]);
        
        $oldHousehold = $family->household;
        $newHousehold = Household::findOrFail($newHouseholdId);
        
        // Check purok change
        $purokChanged = $oldHousehold->purok_id !== $newHousehold->purok_id;
        
        \Log::info('Purok comparison:', [
            'old_purok_id' => $oldHousehold->purok_id,
            'new_purok_id' => $newHousehold->purok_id,
            'purok_changed' => $purokChanged,
        ]);
        
        if ($purokChanged) {
            // Handle residence history...
            $activeFamilyHistory = FamilyResidenceHistory::where('family_id', $familyId)
                ->where('status', 'active')
                ->first();
            
            if ($activeFamilyHistory) {
                $activeFamilyHistory->update(['status' => 'moved']);
            }
            
            FamilyResidenceHistory::create([
                'family_id' => $familyId,
                'purok_id' => $newHousehold->purok_id,
                'is_indigent' => $family->is_indigent,
                'is_4ps' => $family->is_4ps,
                'is_iwas_gutom' => $family->is_iwas_gutom,
                'status' => 'active',
            ]);
            
            $residents = Resident::where('family_id', $familyId)
                ->where('status', 'active')
                ->get();
            
            foreach ($residents as $resident) {
                ResidenceHistory::where('resident_id', $resident->id)
                    ->where('status', 'active')
                    ->update(['status' => 'moved']);
                
                ResidenceHistory::create([
                    'resident_id' => $resident->id,
                    'purok_id' => $newHousehold->purok_id,
                    'status' => 'active',
                ]);
            }
        }
        
        // THE FIX: Use raw update to verify
        $updateResult = DB::table('families')
            ->where('id', $familyId)
            ->update(['household_id' => $newHouseholdId]);
        
        \Log::info('Raw update result:', [
            'rows_affected' => $updateResult,
            'family_id' => $familyId,
            'new_household_id' => $newHouseholdId,
        ]);
        
        $familyAfter = Family::findOrFail($familyId);
        \Log::info('AFTER UPDATE - Family state:', [
            'family_id' => $familyAfter->id,
            'household_id' => $familyAfter->household_id,
            'expected' => $newHouseholdId,
            'match' => $familyAfter->household_id == $newHouseholdId,
            'table_check' => DB::table('families')->find($familyId),
        ]);
        
        DB::commit();
        
        \Log::info('Transaction committed');
        
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 4,
            'activity'  => 'Transferred Family #' . $familyId . ' to ' . $newHousehold->purok->name . '.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Family transferred successfully',
            'data' => [
                'family_id' => $familyAfter->id,
                'old_household_id' => $oldHousehold->id,
                'new_household_id' => $familyAfter->household_id,
                'verified' => $familyAfter->household_id == $newHouseholdId,
            ],
        ], 200);
        
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Family transfer failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to transfer family: ' . $e->getMessage(),
        ], 500);
    }
}
    public function getAllFamilies(Request $request)
    {
        // Get the current user's personnel info
        $user = Auth::user();

        // Determine personnel type (Midwife or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. No associated personnel found.'
            ], 403);
        }

        // Initialize query - get ALL families
        $query = Family::with(['household.purok.barangay', 'residents']);

        \Log::info($request->input('search'));
        
        // Apply Search filter (by resident full name)
        if ($request->filled('search')) {
            $search = strtolower(trim($request->input('search')));
            
            // Get all families first, then filter in PHP since fields are encrypted
            $allFamilies = $query->get();
            
            $filteredFamilies = $allFamilies->filter(function ($family) use ($search) {
                return $family->residents->some(function ($resident) use ($search) {
                    $fullName = trim(
                        ($resident->firstName ?? '') . ' ' . 
                        ($resident->middleName ?? '') . ' ' . 
                        ($resident->lastName ?? '')
                    );
                    
                    return stripos($fullName, $search) !== false;
                });
            });

            // Take first 20 results
            $families = $filteredFamilies->take(20)->values();
        } else {
            // Get first 20 families when no search
            $families = $query->take(20)->get();
        }

        // Attach purok and barangay info to each family
        $families->transform(function ($family) {
            $family->purok = $family->household->purok ?? null;
            $family->barangay = $family->household->purok->barangay ?? null;
            return $family;
        });

        // Simple JSON response
        return response()->json([
            'families' => $families
        ]);
    }


    public function update(Request $request, int $id)
    {
        $user = Auth::user();

        // Determine personnel type
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. No associated personnel found.'
            ], 403);
        }
        $validated = $request->validate([
            'household_id'  => 'sometimes|integer|exists:households,id',
            'is_4ps'        => 'sometimes|boolean',
            'is_indigent'   => 'sometimes|boolean',
            'is_iwas_gutom' => 'sometimes|boolean',
        ]);

        $is4ps = $validated['is_4ps'];
        $isIndigent = $validated['is_indigent'];
        $isIwasGutom = $validated['is_iwas_gutom'];

        // Find the family
        $family = Family::findOrFail($id);

        // Authorization: Ensure medicine belongs to the same barangay
        if ($family->household->purok->brgy_id !== $user->personnel->brgy_id) {
            abort(403, 'Unauthorized to view this family');
        }

        // Check if household changed (family moved)
        $householdChanged = isset($validated['household_id']) && $validated['household_id'] != $family->household_id;

        if ($householdChanged) {
            $oldHousehold = $family->household;
            $newHousehold = Household::findOrFail($validated['household_id']);

            // Check if purok changed
            if ($oldHousehold->purok_id != $newHousehold->purok_id) {
                // Mark previous history as "moved"
                FamilyResidenceHistory::where('family_id', $family->id)
                    ->where('status', 'active')
                    ->update(['status' => 'moved']);

                // Create new history for new location
                FamilyResidenceHistory::create([
                    'family_id'     => $family->id,
                    'purok_id'      => $newHousehold->purok_id,
                    'is_indigent'   => $isIndigent,
                    'is_4ps'        => $is4ps,
                    'is_iwas_gutom' => $isIwasGutom,
                    'status'        => 'active',
                ]);

                // Log the move
                ActivityLog::create([
                    'user_id'   => $user->id,
                    'module_id' => 4,
                    'activity'  => 'Family moved from Purok ' . ucfirst($oldHousehold->purok->name) . 
                                ' to Purok ' . ucfirst($newHousehold->purok->name) . '.',
                ]);
            } else {
                // Same purok, just household change - update history
                FamilyResidenceHistory::where('family_id', $family->id)
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);

                FamilyResidenceHistory::create([
                    'family_id'     => $family->id,
                    'purok_id'      => $newHousehold->purok_id,
                    'is_indigent'   => $isIndigent,
                    'is_4ps'        => $is4ps,
                    'is_iwas_gutom' => $isIwasGutom,
                    'status'        => 'active',
                ]);
            }
        } else {
            // Check if family data changed
            $dataChanged = (
                $family->is_indigent != $isIndigent ||
                $family->is_4ps != $is4ps ||
                $family->is_iwas_gutom != $isIwasGutom
            );

            if ($dataChanged) {
                // Mark old history as inactive and create new one
                FamilyResidenceHistory::where('family_id', $family->id)
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);

                FamilyResidenceHistory::create([
                    'family_id'     => $family->id,
                    'purok_id'      => $family->household->purok_id,
                    'is_indigent'   => $isIndigent,
                    'is_4ps'        => $is4ps,
                    'is_iwas_gutom' => $isIwasGutom,
                    'status'        => 'active',
                ]);
            }
        }

        // Update the family
        $family->update([
            'household_id'  => $validated['household_id'] ?? $family->household_id,
            'is_4ps'        => $is4ps,
            'is_indigent'   => $isIndigent,
            'is_iwas_gutom' => $isIwasGutom,
        ]);

        // Log the update
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 4,
            'activity'  => 'Updated family ' . $id . '.',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Family updated successfully.',
            'data'    => $family->fresh(),
        ], 200);
    }

    public function setStatus(Request $request)
    {
        $user = Auth::user();

        // Determine personnel type
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. No associated personnel found.'
            ], 403);
        }
        // Validate the request
        $request->validate([
            'family_id' => 'required|exists:families,id',
            'status' => 'required|in:active,inactive'
        ]);
        try {
            DB::beginTransaction();

            // Find the family
            $family = Family::findOrFail($request->family_id);
            // Authorization: Ensure family belongs to the same barangay
            if ($family->household->purok->brgy_id !== $user->personnel->brgy_id) {
                abort(403, 'Unauthorized to view this family');
            }
            // Update family status
            $family->status = $request->status;
            $family->save();
            // If setting family to inactive, cascade the changes
            if ($request->status === 'inactive') {
                // Get all residents belonging to this family
                $residents = Resident::where('family_id', $family->id)
                    ->where('status', '!=', 'deceased') // Exclude deceased residents
                    ->get();
                foreach ($residents as $resident) {
                    // Update resident status to 'moved'
                    $resident->status = 'moved';
                    $resident->save();

                    // Update all active residence histories for this resident
                    ResidenceHistory::where('resident_id', $resident->id)
                        ->where('status', 'active')
                        ->update([
                            'status' => 'moved',
                            'updated_at' => now() // Optional: track when they moved
                        ]);
                }
            }
            // Log the update
            ActivityLog::create([
                'user_id'   => $user->id,
                'module_id' => 4,
                'activity'  => 'Updated family ' . $request->family_id. '.',
            ]);

            DB::commit();

            
            return response()->json([
                'success' => true,
                'message' => 'Family status updated successfully',
                'data' => [
                    'family' => $family,
                    'affected_residents' => isset($residents) ? $residents->count() : 0
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update family status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
