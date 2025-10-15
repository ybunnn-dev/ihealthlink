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
            'module_id' => 5, // replace with correct module ID for households
            'activity'  => 'Added a new family in Purok ' . ucfirst($purok->name) . '.',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Family successfully added',
            'data'    => $family,
        ]);
    }

}
