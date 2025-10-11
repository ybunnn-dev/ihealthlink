<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Barangay;
use App\Models\Household;
use App\Models\Family;

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

}
