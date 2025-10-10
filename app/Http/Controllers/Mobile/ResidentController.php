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
    public function index()
    {
        $personnel = Auth::user()->bhw;

        // Find the barangay and the puroks that the user manages
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        // Get the households that belong to the puroks of that barangay
        $purokIds = $puroks->pluck('id');
        $households = Household::whereIn('purok_id', $purokIds)->get();

        // Get the families
        $householdIds = $households->pluck('id');
        $families = Family::with('household.purok')
            ->whereIn('household_id', $householdIds)
            ->get();

        // Get the residents
        $familyIds = $families->pluck('id');
        $residents = Resident::with('family.household.purok')
            ->whereIn('family_id', $familyIds)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $residents
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
