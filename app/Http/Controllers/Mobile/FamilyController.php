<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Barangay;
use App\Models\Household;
use App\Models\Family;
use App\Models\FamilyResidenceHistory;
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

        // Find barangay and its puroks
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay?->puroks ?? collect();

        // Get all households in the barangay's puroks
        $purokIds = $puroks->pluck('id');
        $householdIds = Household::whereIn('purok_id', $purokIds)->pluck('id');

        // Load families and residents
        $families = Family::with(['household.purok.barangay', 'residents'])
            ->whereIn('household_id', $householdIds)
            ->get();

        // FILTER: Search (by decrypted resident names)
        if ($request->filled('search')) {
            $search = strtolower($request->search);

            $families = $families->filter(function ($family) use ($search) {
                return $family->residents->contains(function ($resident) use ($search) {
                    return str_contains(strtolower($resident->firstName), $search)
                        || str_contains(strtolower($resident->middleName), $search)
                        || str_contains(strtolower($resident->lastName), $search);
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

}
