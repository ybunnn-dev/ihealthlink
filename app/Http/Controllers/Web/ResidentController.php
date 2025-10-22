<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Resident;
use App\Models\Family;
use App\Models\Household;
use App\Models\Barangay;
use App\Models\ResidenceHistory;
use App\Models\HealthProgram;
use App\Helpers\ProjectCrypt;
use App\Models\ActivityLog;
use App\Models\EnrolledResident;
use App\Models\BasicHealthRecord;

class ResidentController extends Controller
{  
    public function index(){
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
        ->get(); 

        $familyIds = $families->pluck('id');
        $residents = Resident::with('family.household.purok')
        ->whereIn('family_id', $familyIds)
        ->paginate(7);


        return view('midwife.resident-list', [
            'barangay' => $barangay,
            'puroks' => $puroks,
            'households' => $households,
            'families' => $families,
            'residents' => $residents,
        ]);
    }

    
    public function addResident(Request $request)
    {
        $rules = [
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'middle_name'         => 'nullable|string|max:255',
            'suffix'              => 'nullable|string|max:50',
            'contact_no'          => 'nullable|string|max:20',
            'birthdate'           => 'required|string',
            'family_id'           => 'required|integer',
            'educational_attainment' => 'required|string|max:255',
            'philhealth_no' => 'nullable|string|max:255',
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
            'educational_attainment' => $validated['educational_attainment'],
            'philhealth_no' => $validated['philhealth_no'] ?? null,
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

        $household = $resident->family->household ?? null;
        $purokId = $household->purok_id ?? null;

        // Create residence history
        ResidenceHistory::create([
            'resident_id' => $resident->id,
            'purok_id'    => $purokId,
            'status'      => 'active',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Create empty basic health record
        BasicHealthRecord::create([
            'resident_id' => $resident->id,
            'weight' => null,
            'height' => null,
            'weight_grams' => null,
            'status' => 'alive',
            'health_records' => null,
            'waist_circumference' => null,
            'systolic_pressure' => null,
            'diastolic_pressure' => null,
            'is_pregnant' => false,
            'is_lactating' => false,
        ]);

        // Calculate age and enroll in PhilPEN TCL if eligible
        $age = Carbon::parse($validated['birthdate'])->age;
        
        if ($age >= 20 && $age <= 59) {
            $this->enrollPhilpen($resident->id);
        }

        // Log the activity
        $residentName = trim($validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name'] . ' ' . ($validated['suffix'] ?? ''));
        $purokName = $household->purok->name ?? 'Unknown';
        
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'module_id' => 2, // replace with correct module ID for residents
            'activity'  => 'Added a new resident: ' . $residentName . ' in ' . ucfirst($purokName) . '.',
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Resident created successfully',
            'data' => $resident
        ]);
    }


    private function enrollPhilpen($residentId)
    {
        // Find the PhilPEN TCL program
        $program = HealthProgram::where('category', 'philpen_tcl')
            ->where('status', 'active') // Optional: ensure program is active
            ->first();
        
        if (!$program) {
            // Log or handle case where program doesn't exist
            \Log::warning('PhilPEN TCL program not found for resident enrollment', ['resident_id' => $residentId]);
            return;
        }

        // Check if already enrolled to avoid duplicates
        $existingEnrollment = EnrolledResident::where('resident_id', $residentId)
            ->where('program_id', $program->id)
            ->first();
        
        if ($existingEnrollment) {
            return; // Already enrolled
        }

        // Enroll the resident
        EnrolledResident::create([
            'resident_id' => $residentId,
            'program_id' => $program->id,
            'enrolled_by' => auth()->id(),
            'status' => 'active',
        ]);
    }

    public function show(Resident $resident){

        $resident->load([
            'family.household.purok.barangay',
            'basicHealthRecord',
        ]);


        return view('midwife.spec-resident', [
            'resident' => $resident,
        ]);
    }
    public function ynToBoolOrNull($value)
    {
        if ($value === null) {
            return null; // keep as null
        }

        return $value === "Yes" ? 1 : 0;
    }
    
    
    public function getResident(Request $request)
    {
        $user = Auth::user();

        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        }else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);

        if (!$barangay) {
            return response()->json(['error' => 'Barangay not found.'], 404);
        }

        $puroks = $barangay->puroks;
        $purokIds = $puroks->pluck('id');

        $programId = $request->input('healthProgramId');
        if (!$programId) {
            return response()->json(['error' => 'Health Program ID is required.'], 422);
        }

        $program = HealthProgram::find($programId);
        if (!$program) {
            return response()->json(['error' => 'Health Program not found.'], 404);
        }

        $today = now()->toDateString();

        $residents = Resident::with('family.household.purok')
            ->whereHas('family.household', function ($q) use ($purokIds) {
                $q->whereIn('purok_id', $purokIds);
            })
            ->whereDoesntHave('enrolledResidents', function ($q) use ($programId) {
                $q->where('program_id', $programId);
            })
            ->get(); // Fetch all first

        // --- Filter by age (decrypted birthdate) ---
        $residents = $residents->filter(function ($resident) use ($program, $today) {
            if (!$resident->birthdate) return false;

            try {
                $birthdate = Carbon::parse($resident->birthdate);
                $age = $birthdate->diffInYears($today);
                return $age >= $program->age_min && $age <= $program->age_max;
            } catch (\Exception $e) {
                \Log::warning("Invalid birthdate format for resident ID {$resident->id}");
                return false;
            }
        });

        // --- Search filter (decrypted fields) ---
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $residents = $residents->filter(function ($resident) use ($search) {
                return str_contains(strtolower($resident->firstName ?? ''), $search)
                    || str_contains(strtolower($resident->middleName ?? ''), $search)
                    || str_contains(strtolower($resident->lastName ?? ''), $search);
            });
        }

        // --- Filter by purok ---
        if ($request->filled('purok_id')) {
            $purokId = $request->input('purok_id');
            $residents = $residents->filter(function ($resident) use ($purokId) {
                return $resident->family?->household?->purok_id == $purokId;
            });
        }
        // --- Attach purok info ---
        $residents->each(function ($resident) {
            $resident->purok = $resident->family->household->purok ?? null;
        });

        $residents = $residents->take(10)->values();

        return response()->json([
            'residents' => $residents, // reset indexes
            'puroks' => $puroks
        ]);
    }
    
    public function getWRA(Request $request)
    {
        $user = Auth::user();

        // Determine personnel type (Midwife or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        }else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        if (!$barangay) {
            return response()->json(['error' => 'Barangay not found.'], 404);
        }

        $puroks = $barangay->puroks;
        $purokIds = $puroks->pluck('id');

        // --- Validate health program ---
        $programId = $request->input('healthProgramId');
        if (!$programId) {
            return response()->json(['error' => 'Health Program ID is required.'], 422);
        }

        $program = HealthProgram::find($programId);
        if (!$program) {
            return response()->json(['error' => 'Health Program not found.'], 404);
        }

        $today = now();

        // --- Base Query: only unencrypted filters (relations, sex, enrollment, etc.) ---
        $residents = Resident::with('family.household.purok')
            ->whereHas('family.household', function ($q) use ($purokIds) {
                $q->whereIn('purok_id', $purokIds);
            })
            ->where('sex', 'female') // not encrypted
            ->whereDoesntHave('enrolledResidents', function ($q) use ($programId) {
                $q->where('program_id', $programId)
                ->where('status', 'active');
            })
            ->get(); // Fetch first before filtering encrypted/decrypted data

        // --- AGE FILTER: 10–49 (based on decrypted birthdate) ---
        $residents = $residents->filter(function ($resident) use ($program, $today) {
            if (!$resident->birthdate) return false;

            try {
                $birthdate = Carbon::parse($resident->birthdate);
                $age = $birthdate->diffInYears($today);
                return $age >= $program->age_min && $age <= $program->age_max;
            } catch (\Exception $e) {
                \Log::warning("Invalid birthdate format for resident ID {$resident->id}");
                return false;
            }
        });

        // --- SEARCH FILTER: by decrypted names ---
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));

            $residents = $residents->filter(function ($resident) use ($search) {
                return str_contains(strtolower($resident->firstName ?? ''), $search)
                    || str_contains(strtolower($resident->middleName ?? ''), $search)
                    || str_contains(strtolower($resident->lastName ?? ''), $search);
            });
        }

        // --- PUROK FILTER ---
        if ($request->filled('purok_id')) {
            $purokId = $request->input('purok_id');

            $residents = $residents->filter(function ($resident) use ($purokId) {
                return $resident->family?->household?->purok_id == $purokId;
            });
        }

        // --- Attach Purok Info ---
        $residents->each(function ($resident) {
            $resident->purok = $resident->family->household->purok ?? null;
        });

        $residents = $residents->take(10)->values();

        // --- Return final response ---
        return response()->json([
            'residents' => $residents, // reset indexes
            'puroks' => $puroks
        ]);
    }

    public function getMother(Request $request)
    {
        $user = Auth::user();

        // Determine personnel type (Midwife or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        }else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        if (!$barangay) {
            return response()->json(['error' => 'Barangay not found.'], 404);
        }

        $puroks = $barangay->puroks;
        $purokIds = $puroks->pluck('id');

        // --- Validate health program ---
        $programId = $request->input('healthProgramId');
        if (!$programId) {
            return response()->json(['error' => 'Health Program ID is required.'], 422);
        }

        $program = HealthProgram::find($programId);
        if (!$program) {
            return response()->json(['error' => 'Health Program not found.'], 404);
        }

        $today = now();

        // --- Base Query: only unencrypted filters (relations, sex, enrollment, etc.) ---
        $residents = Resident::with('family.household.purok')
            ->whereHas('family.household', function ($q) use ($purokIds) {
                $q->whereIn('purok_id', $purokIds);
            })
            ->where('sex', 'female') // not encrypted
            ->get(); // Fetch first before filtering encrypted/decrypted data
        
        \Log::info($residents);

        // --- AGE FILTER: 10–49 (based on decrypted birthdate) ---
        $residents = $residents->filter(function ($resident) use ($program, $today) {
            if (!$resident->birthdate) return false;
         
            try {
                $birthdate = Carbon::parse($resident->birthdate);
                $age = $birthdate->diffInYears($today);
                return $age >= 10 && $age <= 49;
            } catch (\Exception $e) {
                \Log::warning("Invalid birthdate format for resident ID {$resident->id}");
                return false;
            }
        });

        \Log::info($residents);

        // --- SEARCH FILTER: by decrypted names ---
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));

            $residents = $residents->filter(function ($resident) use ($search) {
                return str_contains(strtolower($resident->firstName ?? ''), $search)
                    || str_contains(strtolower($resident->middleName ?? ''), $search)
                    || str_contains(strtolower($resident->lastName ?? ''), $search);
            });
        }

        // --- PUROK FILTER ---
        if ($request->filled('purok_id')) {
            $purokId = $request->input('purok_id');

            $residents = $residents->filter(function ($resident) use ($purokId) {
                return $resident->family?->household?->purok_id == $purokId;
            });
        }

        // --- Attach Purok Info ---
        $residents->each(function ($resident) {
            $resident->purok = $resident->family->household->purok ?? null;
        });

        $residents = $residents->take(10)->values();

        return response()->json([
            'residents' => $residents, 
        ]);
    }

}   
