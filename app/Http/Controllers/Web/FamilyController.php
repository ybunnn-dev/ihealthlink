<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function update(Request $request, int $id)
    {
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
                'message' => 'Unauthorized access. No associated personnel found.'
            ], 403);
        }

        $validated = $request->validate([
            'household_id'  => 'sometimes|integer|exists:households,id',
            'is_4ps'        => 'sometimes|string|in:Yes,No',
            'is_indigent'   => 'sometimes|string|in:Yes,No',
            'is_iwas_gutom' => 'sometimes|string|in:Yes,No',
        ]);

        // Find the family
        $family = Family::findOrFail($id);

        // Convert Yes/No to booleans if provided
        $is4ps = isset($validated['is_4ps']) ? ($validated['is_4ps'] === 'Yes') : $family->is_4ps;
        $isIndigent = isset($validated['is_indigent']) ? ($validated['is_indigent'] === 'Yes') : $family->is_indigent;
        $isIwasGutom = isset($validated['is_iwas_gutom']) ? ($validated['is_iwas_gutom'] === 'Yes') : $family->is_iwas_gutom;

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
}
