<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Resident;
use App\Models\ResidenceHistory;
use App\Models\HealthSigns;
use App\Models\ResidentMedicalHistory;
use App\Models\ResidentFamilyHistory;
use App\Models\Family;
use App\Models\Household;
use App\Models\Barangay;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ResidentController extends Controller
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

        // Fetch barangay and puroks under the user
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay?->puroks ?? collect();

        // Get households belonging to the user's puroks
        $purokIds = $puroks->pluck('id');
        $householdIds = Household::whereIn('purok_id', $purokIds)->pluck('id');

        // Families within those households
        $familyIds = Family::whereIn('household_id', $householdIds)->pluck('id');

        // Base resident query (unencrypted filters)
        $residentsQuery = Resident::with('family.household.purok')
            ->whereIn('family_id', $familyIds);

        /**
         * FILTER BY PUROK
         */
        if ($request->filled('purok_id')) {
            $purokId = $request->purok_id;
            $residentsQuery->whereHas('family.household', function ($q) use ($purokId) {
                $q->where('purok_id', $purokId);
            });
        }

        // Fetch residents after DB-level filters
        $residents = $residentsQuery->get();

        /**
         * SEARCH (for encrypted names)
         */
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $residents = $residents->filter(function ($resident) use ($search) {
                return str_contains(strtolower($resident->firstName), $search) ||
                    str_contains(strtolower($resident->middleName), $search) ||
                    str_contains(strtolower($resident->lastName), $search);
            })->values();
        }

        /**
         * FILTER BY AGE GROUP (for encrypted birthdate)
         */
        $ageRanges = [
            'infant' => [0, 1],
            'child' => [2, 12],
            'teen' => [13, 17],
            'adult' => [18, 59],
            'senior' => [60, 200],
        ];

        if ($request->filled('age_group') && isset($ageRanges[$request->age_group])) {
            [$min, $max] = $ageRanges[$request->age_group];
            $today = now();

            $residents = $residents->filter(function ($resident) use ($min, $max, $today) {
                try {
                    $birthdate = \Carbon\Carbon::parse($resident->birthdate);
                    $age = $birthdate->diffInYears($today);
                    return $age >= $min && $age <= $max;
                } catch (\Exception $e) {
                    return false; // Skip invalid or missing birthdates
                }
            })->values();
        }

        /**
         * PAGINATION (manual, since data is filtered in-memory)
         */
        $page = $request->get('page', 1);
        $perPage = 20;

        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $residents->forPage($page, $perPage),
            $residents->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return response()->json([
            'success' => true,
            'data' => $paginated,
            'puroks' => $puroks,
        ]);
    }


    public function show(Resident $resident){

        $resident->load([
            'family.household.purok',
            'basicHealthRecord',
        ]);

        return response()->json([
            'success' => true,
            'resident' => $resident
        ]);
    }

    public function addResident(Request $request)
    {
        // Validation rules
        $rules = [
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'middle_name'         => 'nullable|string|max:255',
            'suffix'              => 'nullable|string|max:50',
            'contact_no'          => 'nullable|string|max:20',
            'birthdate'           => 'required|string', // expect m/d/Y format
            'family_id'           => 'required|integer',
            'relationship_to_head'=> 'required|string|max:255',
            'civil_status'        => 'required|string|max:255',
            'religion'            => 'required|string|max:255',
            'ethnicity'           => 'required|string',
            'employment_status'   => 'required|string|max:255',
            'is_pwd'              => 'boolean',
            'pwd_id'              => 'nullable|string|max:100',
            'is_indigenous'       => 'boolean',
            'emergency_contact_no' => 'nullable|string|max:20',
            'is_solo_parent'      => 'boolean',
            'is_philhealth_member'=> 'boolean',
            'years_of_residency'  => 'required|integer|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Convert birthdate to Y-m-d
        

        // Create resident
        $resident = Resident::create([
            'family_id'           => $validated['family_id'],
            'added_by'            => auth()->id(),
            'firstName'           => $validated['first_name'],
            'lastName'            => $validated['last_name'],
            'middleName'          => $validated['middle_name'] ?? null,
            'suffix'              => $validated['suffix'] ?? null,
            'birthdate'           => $validated['birthdate'],
            'sex'                 => $request->sex ?? null,
            'contact_no'          => $validated['contact_no'] ?? null,
            'civil_status'        => $validated['civil_status'],
            'family_relationship' => $validated['relationship_to_head'],
            'is_pwd'              => $validated['is_pwd'] ?? false,
            'pwd_id'              => $validated['pwd_id'] ?? null,
            'is_indigenous'       => $validated['is_indigenous'] ?? false,
            'if_philhealth'       => $validated['is_philhealth_member'] ?? false,
            'if_solo_parent'      => $validated['is_solo_parent'] ?? false,
            'employment_status'   => $validated['employment_status'],
            'status'              => 'active',
            'religion'            => $validated['religion'],
            'ethnicity'           => $validated['ethnicity'],
            'emergencyContactNo'  => $validated['emergency_contact_no'] ?? null,
        ]);

        // Get the household of the family
        $household = $resident->family->household ?? null;
        $purokId = $household->purok_id ?? null;

        // Determine the residence start date
        $years = $validated['years_of_residency'] ?? 0;
        if ($years < 1) {
            // January 1st of the current year
            $createdAt = Carbon::now()->startOfYear();
        } else {
            $createdAt = Carbon::now()->subYears($years);
        }

        // Create residence history
        ResidenceHistory::create([
            'resident_id' => $resident->id,
            'purok_id'    => $purokId,
            'status'      => 'active',
            'created_at'  => $createdAt,
            'updated_at'  => now(),
        ]);

        
        return response()->json([
            'status' => 'success',
            'message' => 'Resident created successfully',
            'data' => $resident
        ]);
    }
}
