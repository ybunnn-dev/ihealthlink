<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Resident;
use App\Models\ResidenceHistory;
use App\Models\HealthSigns;
use App\Models\ResidentMedicalHistory;
use App\Models\BasicHealthRecord;
use App\Models\ResidentFamilyHistory;
use App\Models\Family;
use App\Models\Household;
use App\Models\Barangay;
use App\Models\ActivityLog;
use App\Models\HealthProgram;
use App\Models\EnrolledResident;
use App\Models\Purok;
use App\Models\Consultation;

class ResidentController extends Controller
{   
    public function index(Request $request)
    {
        $personnel = Auth::user()->midwife ?? Auth::user()->bhwWeb;

        // Find the barangay and the puroks that the user manages
        $barangay = Barangay::with('puroks')->find($personnel->brgy_id);
        $puroks = $barangay->puroks;

        // Get the purok IDs
        $purokIds = $puroks->pluck('id');

        // Build the query
        $query = Resident::with('family.household.purok')
            ->whereHas('family.household', function($q) use ($purokIds) {
                $q->whereIn('purok_id', $purokIds);
            });

        // Apply purok filter (this can be done at DB level)
        if ($request->filled('purok_id')) {
            $query->whereHas('family.household', function($q) use ($request) {
                $q->where('purok_id', $request->purok_id);
            });
        }

        // Get all residents (we'll filter in PHP due to encryption)
        $allResidents = $query->get();

        // Apply search filter (in PHP, after decryption)
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $allResidents = $allResidents->filter(function($resident) use ($searchTerm) {
                // Search by resident ID
                if (preg_match('/^R?-?(\d+)$/i', $searchTerm, $matches)) {
                    $residentId = (int)$matches[1];
                    if ($resident->id == $residentId) {
                        return true;
                    }
                }
                
                // Search by full name (encrypted fields are auto-decrypted by accessor)
                $fullName = strtolower($resident->firstName . ' ' . $resident->middleName . ' ' . $resident->lastName);
                $nameWithoutMiddle = strtolower($resident->firstName . ' ' . $resident->lastName);
                
                return str_contains($fullName, $searchTerm) || str_contains($nameWithoutMiddle, $searchTerm);
            });
        }

        // Apply age group filter (in PHP, after decryption)
        if ($request->filled('age_group')) {
            $ageGroup = $request->age_group;
            $allResidents = $allResidents->filter(function($resident) use ($ageGroup) {
                try {
                    $birthdate = \Illuminate\Support\Carbon::parse($resident->birthdate);
                    $age = $birthdate->age;
                    
                    return match($ageGroup) {
                        'infant' => $age >= 0 && $age <= 1,
                        'child' => $age >= 2 && $age <= 12,
                        'teen' => $age >= 13 && $age <= 17,
                        'adult' => $age >= 18 && $age <= 59,
                        'senior' => $age >= 60,
                        default => true
                    };
                } catch (\Exception $e) {
                    return false;
                }
            });
        }

        // Manually paginate the filtered collection
        $page = $request->get('page', 1);
        $perPage = 7;
        $total = $allResidents->count();
        $results = $allResidents->forPage($page, $perPage);
        
        $residents = new \Illuminate\Pagination\LengthAwarePaginator(
            $results, 
            $total, 
            $perPage, 
            $page, 
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'html' => view('components.resident.resident-table-rows', compact('residents'))->render(),
                'pagination' => view('components.resident.pagination', compact('residents'))->render(),
            ]);
        }

        // Return full view for initial page load
        return view('midwife.resident-list', [
            'barangay' => $barangay,
            'puroks' => $puroks,
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

    public function show(Request $request, Resident $resident)
    {
        $resident->load([
            'family.household.purok.barangay',
            'basicHealthRecord',
        ]);

        // Start with the consultations query
        $query = $resident->consultations();

        // Apply date filters based on request
        $dateFilter = $request->input('date_filter');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if ($dateFilter) {
            switch ($dateFilter) {
                case 'Last Week':
                    $query->where('updated_at', '>=', \Carbon\Carbon::now()->subWeek());
                    break;
                case 'Month':
                    $query->where('updated_at', '>=', \Carbon\Carbon::now()->subMonth());
                    break;
                case 'Last Year':
                    $query->where('updated_at', '>=', \Carbon\Carbon::now()->subYear());
                    break;
            }
        } elseif ($fromDate && $toDate) {
            $query->whereBetween('updated_at', [$fromDate, $toDate]);
        }

        // Order by most recent and paginate
        $consultations = $query->orderBy('updated_at', 'desc')->paginate(7)->withQueryString();

        // Log the pagination data
        \Log::info('Consultations pagination', [
            'resident_id' => $resident->id,
            'date_filter' => $dateFilter,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'total' => $consultations->total(),
            'current_page' => $consultations->currentPage(),
        ]);

        // If AJAX request, return only the table content
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('components.resident.consultation-history-table', [
                'history' => $consultations
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => [
                    'current_page' => $consultations->currentPage(),
                    'last_page' => $consultations->lastPage(),
                    'per_page' => $consultations->perPage(),
                    'total' => $consultations->total(),
                    'from' => $consultations->firstItem(),
                    'to' => $consultations->lastItem(),
                ]
            ]);
        }

        // Regular page load
        return view('midwife.spec-resident', [
            'resident' => $resident,
            'consultations' => $consultations,
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

    public function updateResident(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'id' => 'required|integer|exists:residents,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'contact_no' => 'required|string|max:20',
            'sex' => 'required|in:male,female',
            'birthdate' => 'required|date',
            'status' => 'required|in:active,deceased,moved',
            'civil_status' => 'required|in:single,married,widowed,separated,divorced',
            'religion' => 'required|string|max:100',
            'ethnicity' => 'required|string|max:100',
            'educational_attainment' => 'nullable|string|max:100',
            'employment_status' => 'required|in:employed,unemployed,self-employed,retired,student',
            'is_pwd' => 'required|boolean',
            'pwd_id' => 'nullable|string|max:50',
            'is_indigenous' => 'required|boolean',
            'if_solo_parent' => 'required|boolean',
            'if_philhealth' => 'required|boolean',
            'philhealth_no' => 'nullable|string|max:50',
            'emergency_contact_no' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            // Find the resident
            $resident = Resident::findOrFail($validated['id']);
            
            // Store old status for comparison
            $oldStatus = $resident->status;
            $statusChanged = $oldStatus !== $validated['status'];

            // Build full name for logging
            $residentName = trim(
                $validated['first_name'] . ' ' . 
                ($validated['middle_name'] ? $validated['middle_name'] . ' ' : '') . 
                $validated['last_name'] . 
                ($validated['suffix'] ? ' ' . $validated['suffix'] : '')
            );

            Log::info("Updating resident: {$residentName} (ID: {$resident->id})");

            // Update resident with mapped field names
            $resident->update([
                'firstName' => $validated['first_name'],
                'lastName' => $validated['last_name'],
                'middleName' => $validated['middle_name'],
                'suffix' => $validated['suffix'],
                'contact_no' => $validated['contact_no'],
                'sex' => $validated['sex'],
                'birthdate' => $validated['birthdate'],
                'status' => $validated['status'],
                'civil_status' => $validated['civil_status'],
                'religion' => $validated['religion'],
                'ethnicity' => $validated['ethnicity'],
                'educational_attainment' => $validated['educational_attainment'],
                'employment_status' => $validated['employment_status'],
                'is_pwd' => $validated['is_pwd'],
                'pwd_id' => $validated['pwd_id'],
                'is_indigenous' => $validated['is_indigenous'],
                'if_philhealth' => $validated['if_philhealth'],
                'if_solo_parent' => $validated['if_solo_parent'],
                'philhealth_no' => $validated['philhealth_no'],
                'emergencyContactNo' => $validated['emergency_contact_no'],
            ]);

            Log::info('✅ Resident updated successfully');

            // Handle residence history if status changed to deceased or moved
            if ($statusChanged && in_array($validated['status'], ['deceased', 'moved'])) {
                Log::info("Status changed from '{$oldStatus}' to '{$validated['status']}' - Updating residence history");

                // Find the latest active residence history record
                $latestHistory = ResidenceHistory::where('resident_id', $resident->id)
                    ->where('status', 'active')
                    ->latest('created_at')
                    ->first();

                if ($latestHistory) {
                    // Update the status of the latest active record
                    $latestHistory->update([
                        'status' => $validated['status']
                    ]);

                    Log::info("✅ Updated residence history ID {$latestHistory->id} status to '{$validated['status']}'");
                } else {
                    Log::warning("⚠️ No active residence history found for resident ID {$resident->id}");
                }
            }

            DB::commit();

            // Activity log
            ActivityLog::create([
                'user_id' => auth()->id(),
                'module_id' => 1, // Adjust module_id for residents
                'activity' => "Updated resident: {$residentName}" . 
                            ($statusChanged ? " (Status: {$oldStatus} → {$validated['status']})" : ""),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Resident updated successfully',
                'resident' => $resident,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('--- ❌ Error updating resident ---');
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update resident',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getAllResidents(Request $request)
    {
        // Base resident query - fetch all active residents
        $residentsQuery = Resident::with('family.household.purok.barangay')
            ->where('status', 'active'); // Assuming you have an is_active column
        
        // Check if we need to filter in memory (search or age group)
        $needsMemoryFiltering = $request->filled('search') || 
                            ($request->filled('age_group') && 
                                $request->age_group !== 'All age group' && 
                                $request->age_group !== '');
        
        if ($needsMemoryFiltering) {
            // Get all active residents and filter in memory
            $allResidents = $residentsQuery->get();
            
            // Apply search filter
            if ($request->filled('search')) {
                $searchTerm = strtolower(trim($request->search));
                
                $allResidents = $allResidents->filter(function ($resident) use ($searchTerm) {
                    $firstName = strtolower($resident->firstName ?? '');
                    $lastName = strtolower($resident->lastName ?? '');
                    $middleName = strtolower($resident->middleName ?? '');
                    
                    // Concatenate full name variations
                    $fullName = $firstName . ' ' . $middleName . ' ' . $lastName;
                    $fullNameAlt = $firstName . ' ' . $lastName; // Without middle name
                    
                    // Check if search contains multiple words
                    if (str_contains($searchTerm, ' ')) {
                        // Multi-word search: check against full name variations
                        return str_contains($fullName, $searchTerm) || 
                            str_contains($fullNameAlt, $searchTerm);
                    } else {
                        // Single word: check individual name parts
                        return str_contains($firstName, $searchTerm) ||
                            str_contains($lastName, $searchTerm) ||
                            str_contains($middleName, $searchTerm);
                    }
                });
            }

            // Apply age group filter
            if ($request->filled('age_group') && 
                $request->age_group !== 'All age group' && 
                $request->age_group !== '') {
                
                $ageGroup = $request->age_group;
                
                $allResidents = $allResidents->filter(function ($resident) use ($ageGroup) {
                    if (!$resident->birthdate) {
                        return false;
                    }
                    
                    try {
                        $birthdate = \Carbon\Carbon::parse($resident->birthdate);
                        $age = $birthdate->age;
                        
                        switch ($ageGroup) {
                            case 'Infant (0-1)':
                                return $age >= 0 && $age <= 1;
                            case 'Child (2-12)':
                                return $age >= 2 && $age <= 12;
                            case 'Teen (13-17)':
                                return $age >= 13 && $age <= 17;
                            case 'Adult (18-59)':
                                return $age >= 18 && $age <= 59;
                            case 'Senior (60+)':
                                return $age >= 60;
                            default:
                                return true;
                        }
                    } catch (\Exception $e) {
                        return false;
                    }
                });
            }
            
            // Take only first 20
            $residents = $allResidents->take(20)->values();
        } else {
            // Take first 20 residents without filtering
            $residents = $residentsQuery->limit(20)->get();
        }
        
        return response()->json([
            'success' => true,
            'data' => $residents,
        ]);
    }

    public function transfer(Request $request){
        // Validate and log
        $validated = $request->validate([
            'resident_id' => 'required|integer',
            'family_id' => 'required|integer',
        ]);
        
        \Log::info('Validated transfer request', $validated);
        
        try {
            // Find the resident with their current family and purok
            $resident = Resident::with(['family.household.purok'])->findOrFail($validated['resident_id']);
            
            // Get the old purok ID (before transfer)
            $oldPurokId = $resident->family?->household?->purok?->id;
            
            \Log::info('Current resident family', [
                'resident_id' => $resident->id,
                'current_family_id' => $resident->family_id,
                'current_purok_id' => $oldPurokId,
            ]);
            
            // Find the new family with its household and purok
            $newFamily = Family::with(['household.purok'])->findOrFail($validated['family_id']);
            $newPurokId = $newFamily->household?->purok?->id;
            $newPurokName = $newFamily->household?->purok?->name ?? 'Unknown Purok';
            
            \Log::info('New family details', [
                'new_family_id' => $newFamily->id,
                'new_purok_id' => $newPurokId,
                'new_purok_name' => $newPurokName,
            ]);
            
            // Check if purok changed
            if ($oldPurokId !== $newPurokId) {
                \Log::info('Purok changed - updating residence history');
                
                // Find the current active residence history and mark as 'moved'
                ResidenceHistory::where('resident_id', $resident->id)
                    ->where('status', 'active')
                    ->update([
                        'status' => 'moved',
                        'updated_at' => now(),
                    ]);
                
                // Create new residence history for the new purok
                ResidenceHistory::create([
                    'resident_id' => $resident->id,
                    'purok_id' => $newPurokId,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                \Log::info('Residence history updated', [
                    'old_purok_id' => $oldPurokId,
                    'new_purok_id' => $newPurokId,
                ]);
            } else {
                \Log::info('Purok unchanged - no residence history update needed');
            }
            
            // Update the resident's family_id
            $resident->family_id = $validated['family_id'];
            $resident->save();
            
            \Log::info('Resident family_id updated', [
                'resident_id' => $resident->id,
                'new_family_id' => $validated['family_id'],
            ]);
            
            // Build resident full name
            $residentName = trim(
                $resident->firstName . ' ' . 
                ($resident->middleName ? $resident->middleName . ' ' : '') . 
                $resident->lastName . 
                ($resident->suffix ? ' ' . $resident->suffix : '')
            );
            
            // Log the activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'module_id' => 2,
                'activity' => 'Transferred resident: ' . $residentName . ' to ' . ucfirst($newPurokName) . '.',
            ]);
            
            \Log::info('Activity logged', [
                'user_id' => auth()->id(),
                'resident_name' => $residentName,
                'purok_name' => $newPurokName,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Resident transferred successfully',
                'data' => [
                    'resident_id' => $resident->id,
                    'new_family_id' => $validated['family_id'],
                    'new_purok_id' => $newPurokId,
                    'new_purok_name' => $newPurokName,
                    'purok_changed' => $oldPurokId !== $newPurokId,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('Transfer failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to transfer resident: ' . $e->getMessage()
            ], 500);
        }
    }

}   
