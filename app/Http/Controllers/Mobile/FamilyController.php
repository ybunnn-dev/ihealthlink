<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Barangay;
use App\Models\Household;
use App\Models\Family;
use App\Models\FamilyResidenceHistory;
use App\Models\Resident;
use App\Models\ResidenceHistory;
use App\Models\ActivityLog;
use App\Models\Purok;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Determine personnel type (Midwife or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } elseif ($user->bhw && $user->bhw->role_id == 3) {
            $personnel = $user->bhw;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        // Find barangay and its puroks (still needed for non-advanced searches)
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay?->puroks ?? collect();

        // Check if advanced search (search entire database)
        if ($request->filled('is_advanced') && $request->boolean('is_advanced')) {
            \Log::info('Advanced search - searching entire database');
            
            // Load ALL families from the entire database without barangay filter
            $families = Family::with(['household.purok.barangay', 'residents'])->get();
            
            // Get all puroks for the filter dropdown
            $puroks = Purok::all();
            
        } else {
            \Log::info('Regular search - barangay level only');
            
            // Original logic: Only search within personnel's barangay
            $purokIds = $puroks->pluck('id');
            $householdIds = Household::whereIn('purok_id', $purokIds)->pluck('id');
            
            $families = Family::with(['household.purok.barangay', 'residents'])
                ->whereIn('household_id', $householdIds)
                ->get();
        }

        // FILTER: Search (by decrypted resident names)
        if ($request->filled('search')) {
            $search = strtolower($request->search);

            $families = $families->filter(function ($family) use ($search) {
                return $family->residents->contains(function ($resident) use ($search) {
                    // Check individual fields (for single name searches)
                    $matchesIndividual = str_contains(strtolower($resident->firstName), $search)
                        || str_contains(strtolower($resident->middleName), $search)
                        || str_contains(strtolower($resident->lastName), $search);
                    
                    // Check combined full name (for multi-word searches like "John Smith")
                    $fullName = strtolower(trim(
                        $resident->firstName . ' ' . 
                        $resident->middleName . ' ' . 
                        $resident->lastName
                    ));
                    
                    $matchesFullName = str_contains($fullName, $search);
                    
                    return $matchesIndividual || $matchesFullName;
                });
            })->values();
        }

        // FILTER: By Purok
        if ($request->filled('purok_id')) {
            $purokId = $request->purok_id;
            $families = $families->filter(function ($family) use ($purokId) {
                return $family->household?->purok_id == $purokId;
            })->values();
        }

        // PAGINATE manually (because we filtered in PHP)
        $page = $request->input('page', 1);
        $perPage = 20;
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $families->forPage($page, $perPage)->values(),
            $families->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        return response()->json([
            'families' => $paginated,
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

    public function store(Request $request)
    {
        $user = Auth::user();

        // Determine personnel type (Midwife or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } elseif ($user->bhw && $user->bhw->role_id == 3) {
            $personnel = $user->bhw;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        // Validate inputs
        $validated = $request->validate([
            'household_server_id' => 'required|integer|exists:households,id',
            'is4ps'               => 'required|boolean',
            'isIndigent'          => 'required|boolean',
            'is_iwas_gutom'       => 'required|boolean',
        ]);

        // Get the parent household
        $household = Household::findOrFail($validated['household_server_id']);

        // Create the family record
        $family = Family::create([
            'household_id'  => $household->id,
            'status'        => 'active',
            'is_indigent'   => $validated['isIndigent'],
            'is_4ps'        => $validated['is4ps'],
            'is_iwas_gutom' => $validated['is_iwas_gutom'],
        ]);

        // Create a residence history record
        FamilyResidenceHistory::create([
            'family_id'   => $family->id,
            'purok_id'    => $household->purok_id, // Get from the parent household
            'is_indigent' => $validated['isIndigent'],
            'is_4ps'      => $validated['is4ps'],
            'is_iwas_gutom' => $validated['is_iwas_gutom'],
            'status'      => 'active',
        ]);

        // Get the purok name for activity log
        $purok = $household->purok;

        // Log the activity
        ActivityLog::create([
            'user_id'   => $user->id,
            'module_id' => 4, // replace with correct module ID for households
            'activity'  => 'Added a new family in Purok ' . ucfirst($purok->name) . '.',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Family successfully added',
            'data'    => $family,
        ]);
    }
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'is_4ps' => 'boolean',
            'is_indigent' => 'boolean',
            'is_iwas_gutom' => 'boolean',
        ]);

        // Perform the update
        $updatedRows = Family::where('id', $id)->update([
            'is_4ps' => $validated['is_4ps'] ?? false,
            'is_indigent' => $validated['is_indigent'] ?? false,
            'is_iwas_gutom' => $validated['is_iwas_gutom'] ?? false,
        ]);

        // Log the activity if updated
        if ($updatedRows > 0) {
            $user = auth()->user();

            ActivityLog::create([
                'user_id'   => $user->id,
                'module_id' => 4,
                'activity'  => 'Updated family ' . $id . '.',
            ]);
        }

        return response()->json([
            'message' => $updatedRows > 0 ? 'Family updated successfully.' : 'No changes made.',
            'updatedRows' => $updatedRows,
        ]);
    }

    public function storeOrUpdateFamilySync(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Determine personnel type
            if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
                $personnel = $user->bhwWeb;
            } elseif ($user->bhw && $user->bhw->role_id == 3) {
                $personnel = $user->bhw;
            } else {
                $personnel = $user->midwife;
            }

            if (!$personnel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No associated personnel found for this user.'
                ], 404);
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'families' => 'required|array',
                'families.*.local_id' => 'required|integer',
                'families.*.client_uuid' => 'required|string',
                'families.*.household_server_id' => 'required|exists:households,id',
                'families.*.is_indigent' => 'nullable|integer',
                'families.*.is_iwas_gutom' => 'nullable|integer',
                'families.*.is_4ps' => 'nullable|integer',
                'families.*.status' => 'required|string',
                'families.*.updated_at' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $syncedFamilies = [];

            DB::transaction(function () use ($validated, $user, &$syncedFamilies) {
                foreach ($validated['families'] as $familyData) {
                    $existingFamily = Family::where('client_uuid', $familyData['client_uuid'])->first();
                    
                    // Get the target household
                    $newHousehold = Household::find($familyData['household_server_id']);

                    if ($existingFamily) {
                        // Check for conflict resolution (Last Write Wins)
                        $serverUpdatedAt = Carbon::parse($existingFamily->updated_at);
                        $clientUpdatedAt = Carbon::parse($familyData['updated_at']);

                        if ($serverUpdatedAt->greaterThan($clientUpdatedAt)) {
                            // Server has newer data - skip update
                            $syncedFamilies[] = [
                                'local_id' => $familyData['local_id'],
                                'server_id' => $existingFamily->id,
                                'updated_at' => $existingFamily->updated_at->toIso8601String(),
                            ];
                            continue;
                        }

                        // Check if household (and thus purok) has changed
                        $oldPurokId = $existingFamily->household->purok_id;
                        $newPurokId = $newHousehold->purok_id;

                        if ($oldPurokId != $newPurokId) {
                            // Purok changed - mark previous history as "moved"
                            FamilyResidenceHistory::where('family_id', $existingFamily->id)
                                ->where('status', 'active')
                                ->update(['status' => 'moved']);

                            // Create new history record for the new location
                            FamilyResidenceHistory::create([
                                'family_id' => $existingFamily->id,
                                'purok_id' => $newPurokId,
                                'is_indigent' => $familyData['is_indigent'] ?? 0,
                                'is_4ps' => $familyData['is_4ps'] ?? 0,
                                'is_iwas_gutom' => $familyData['is_iwas_gutom'] ?? 0,
                                'status' => 'active',
                            ]);

                            // Log the move activity
                            $oldPurok = Purok::find($oldPurokId);
                            $newPurok = Purok::find($newPurokId);
                            
                            ActivityLog::create([
                                'user_id' => $user->id,
                                'module_id' => 4,
                                'activity' => 'Family moved from Purok ' . ucfirst($oldPurok->name) . 
                                            ' to Purok ' . ucfirst($newPurok->name) . '.',
                            ]);
                        } else {
                            // Same purok - check if family data changed
                            $dataChanged = (
                                $existingFamily->is_indigent != ($familyData['is_indigent'] ?? 0) ||
                                $existingFamily->is_4ps != ($familyData['is_4ps'] ?? 0) ||
                                $existingFamily->is_iwas_gutom != ($familyData['is_iwas_gutom'] ?? 0)
                            );

                            if ($dataChanged) {
                                // Mark old history as inactive and create new one
                                FamilyResidenceHistory::where('family_id', $existingFamily->id)
                                    ->where('status', 'active')
                                    ->update(['status' => 'inactive']);

                                FamilyResidenceHistory::create([
                                    'family_id' => $existingFamily->id,
                                    'purok_id' => $newPurokId,
                                    'is_indigent' => $familyData['is_indigent'] ?? 0,
                                    'is_4ps' => $familyData['is_4ps'] ?? 0,
                                    'is_iwas_gutom' => $familyData['is_iwas_gutom'] ?? 0,
                                    'status' => 'active',
                                ]);
                            }
                        }

                        // Update the family record
                        $existingFamily->update([
                            'household_id' => $familyData['household_server_id'],
                            'is_indigent' => $familyData['is_indigent'] ?? 0,
                            'is_4ps' => $familyData['is_4ps'] ?? 0,
                            'is_iwas_gutom' => $familyData['is_iwas_gutom'] ?? 0,
                            'status' => $familyData['status'],
                            'updated_at' => $familyData['updated_at'],
                        ]);

                        $syncedFamilies[] = [
                            'local_id' => $familyData['local_id'],
                            'server_id' => $existingFamily->id,
                            'updated_at' => $existingFamily->updated_at->toIso8601String(),
                        ];
                    } else {
                        // New family - create it
                        $family = Family::create([
                            'client_uuid' => $familyData['client_uuid'],
                            'household_id' => $familyData['household_server_id'],
                            'is_indigent' => $familyData['is_indigent'] ?? 0,
                            'is_4ps' => $familyData['is_4ps'] ?? 0,
                            'is_iwas_gutom' => $familyData['is_iwas_gutom'] ?? 0,
                            'status' => $familyData['status'],
                            'created_at' => now(),
                            'updated_at' => $familyData['updated_at'],
                        ]);

                        // Create initial history record
                        FamilyResidenceHistory::create([
                            'family_id' => $family->id,
                            'purok_id' => $newHousehold->purok_id,
                            'is_indigent' => $familyData['is_indigent'] ?? 0,
                            'is_4ps' => $familyData['is_4ps'] ?? 0,
                            'is_iwas_gutom' => $familyData['is_iwas_gutom'] ?? 0,
                            'status' => 'active',
                        ]);

                        // Log activity
                        $purok = Purok::find($newHousehold->purok_id);
                        ActivityLog::create([
                            'user_id' => $user->id,
                            'module_id' => 4,
                            'activity' => 'Added a new family in Purok ' . ucfirst($purok->name) . '.',
                        ]);

                        $syncedFamilies[] = [
                            'local_id' => $familyData['local_id'],
                            'server_id' => $family->id,
                            'updated_at' => $family->updated_at->toIso8601String(),
                        ];
                    }
                }
            });

            return response()->json([
                'message' => 'Families synced successfully!',
                'families' => $syncedFamilies,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Family sync error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function transfer(Request $request) {
        $user = Auth::user();

        // Determine personnel type (Midwife or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } elseif ($user->bhw && $user->bhw->role_id == 3) {
            $personnel = $user->bhw;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        \Log::info('Transfer request received:', $request->all());
        
        // Validate the request
        $validated = $request->validate([
            'family_id' => 'required|integer|exists:families,id',
            'household_id' => 'required|integer|exists:households,id',
        ]);
        
        $familyId = $validated['family_id'];
        $newHouseholdId = $validated['household_id'];
        
        try {
            DB::beginTransaction();
            
            // Step 1: Get the family with its current household
            $family = Family::with('household')->findOrFail($familyId);
            $oldHousehold = $family->household;
            
            // Step 2: Get the new household
            $newHousehold = Household::findOrFail($newHouseholdId);
            
            // Step 3: Check if purok has changed
            $purokChanged = $oldHousehold->purok_id !== $newHousehold->purok_id;
            
            \Log::info('Purok comparison:', [
                'old_purok_id' => $oldHousehold->purok_id,
                'new_purok_id' => $newHousehold->purok_id,
                'purok_changed' => $purokChanged,
            ]);
            
            if ($purokChanged) {
                \Log::info('Purok changed - updating history records');
                
                // Step 4a: Find and update the active family residence history
                $activeFamilyHistory = FamilyResidenceHistory::where('family_id', $familyId)
                    ->where('status', 'active')
                    ->first();
                
                if ($activeFamilyHistory) {
                    $activeFamilyHistory->update(['status' => 'moved']);
                    \Log::info('Updated family history to moved:', ['id' => $activeFamilyHistory->id]);
                }
                
                // Step 4b: Create new family residence history
                FamilyResidenceHistory::create([
                    'family_id' => $familyId,
                    'purok_id' => $newHousehold->purok_id,
                    'is_indigent' => $family->is_indigent,
                    'is_4ps' => $family->is_4ps,
                    'is_iwas_gutom' => $family->is_iwas_gutom,
                    'status' => 'active',
                ]);
                \Log::info('Created new family history for purok:', ['purok_id' => $newHousehold->purok_id]);
                
                // Step 5: Get all active residents in this family
                $residents = Resident::where('family_id', $familyId)
                    ->where('status', 'active')
                    ->get();
                
                \Log::info('Found residents to update:', ['count' => $residents->count()]);
                
                // Step 6: Update residence history for each resident
                foreach ($residents as $resident) {
                    // Mark old residence history as moved
                    ResidenceHistory::where('resident_id', $resident->id)
                        ->where('status', 'active')
                        ->update(['status' => 'moved']);
                    
                    // Create new residence history
                    ResidenceHistory::create([
                        'resident_id' => $resident->id,
                        'purok_id' => $newHousehold->purok_id,
                        'status' => 'active',
                    ]);
                }
                
                \Log::info('Updated residence history for all residents');
            } else {
                \Log::info('Purok unchanged - no history updates needed');
            }
            
            // Step 7: Update the family's household_id
            $family->update(['household_id' => $newHouseholdId]);
            
            DB::commit();
            
            ActivityLog::create([
                'user_id'   => $user->id,
                'module_id' => 4, // replace with correct module ID for households
                'activity'  => 'Transfered Family # '.$family->id .' to ' . $newHousehold->purok->name . '.',
            ]);

            \Log::info('Family transfer completed successfully');
            
            return response()->json([
                'success' => true,
                'message' => 'Family transferred successfully',
                'data' => [
                    'family_id' => $familyId,
                    'old_household_id' => $oldHousehold->id,
                    'new_household_id' => $newHouseholdId,
                    'purok_changed' => $purokChanged,
                    'residents_updated' => $purokChanged ? $residents->count() : 0,
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


}
