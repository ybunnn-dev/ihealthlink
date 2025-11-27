<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ResidentController extends Controller
{   
        public function index(Request $request)
    {
        $user = Auth::user();
        
        // Check if advanced mode is enabled
        $isAdvanced = $request->boolean('is_advanced');

        
        if (!$isAdvanced) {
            // Standard mode: limit to user's barangay
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
            
            // Base resident query limited to user's families
            $residentsQuery = Resident::with('family.household.purok')
                ->whereIn('family_id', $familyIds);
        } else {
            // Advanced mode: fetch from entire database
            $residentsQuery = Resident::with('family.household.purok');
            
            // Fetch all puroks for filter dropdown
            $puroks = Purok::all();
        }
        
        /**
         * FILTER BY PUROK
         */
        $residentsQuery->when($request->filled('purok_id'), function ($query) use ($request) {
            $purokId = $request->purok_id;
            $query->whereHas('family.household', function ($q) use ($purokId) {
                $q->where('purok_id', $purokId);
            });
        });
        
        // Check if we need to filter in memory (search or age group)
        $needsMemoryFiltering = $request->filled('search') || 
                            ($request->filled('age_group') && 
                                $request->age_group !== 'All age group' && 
                                $request->age_group !== '');
        
        if ($needsMemoryFiltering) {
            // Get all residents and filter in memory
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
            
            // Manual pagination
            $page = $request->get('page', 1);
            $perPage = 20;
            $total = $allResidents->count();
            
            $residents = new \Illuminate\Pagination\LengthAwarePaginator(
                $allResidents->forPage($page, $perPage)->values(),
                $total,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            // Paginate residents normally
            $residents = $residentsQuery->paginate(20)->withQueryString();
        }
        
        return response()->json([
            'success' => true,
            'data' => $residents,
            'puroks' => $puroks ?? collect(),
            'is_advanced' => $isAdvanced,
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
            abort(403, 'Unauthorized access.');
        }
        
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'contact_no' => 'nullable|string|max:20',
            'birthdate' => 'required|string',
            'family_id' => 'required|integer',
            'educational_attainment' => 'required|string|max:255',
            'philhealth_no' => 'nullable|string|max:255',
            'civil_status' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'ethnicity' => 'required|string',
            'employment_status' => 'required|string|max:255',
            'is_pwd' => 'boolean',
            'pwd_id' => 'nullable|string|max:100',
            'is_indigenous' => 'boolean',
            'emergency_contact_no' => 'nullable|string|max:20',
            'is_solo_parent' => 'boolean',
            'is_philhealth_member' => 'boolean',
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
            'client_uuid' => Str::uuid()->toString(),  // ← Add UUID
            'family_id' => $validated['family_id'],
            'added_by' => auth()->id(),
            'firstName' => $validated['first_name'],
            'lastName' => $validated['last_name'],
            'middleName' => $validated['middle_name'] ?? null,
            'suffix' => $validated['suffix'] ?? null,
            'birthdate' => $validated['birthdate'],
            'sex' => $request->sex ?? null,
            'contact_no' => $validated['contact_no'] ?? null,
            'civil_status' => $validated['civil_status'],
            'educational_attainment' => $validated['educational_attainment'],
            'philhealth_no' => $validated['philhealth_no'] ?? null,
            'is_pwd' => $validated['is_pwd'] ?? false,
            'pwd_id' => $validated['pwd_id'] ?? null,
            'is_indigenous' => $validated['is_indigenous'] ?? false,
            'if_philhealth' => $validated['is_philhealth_member'] ?? false,
            'if_solo_parent' => $validated['is_solo_parent'] ?? false,
            'employment_status' => $validated['employment_status'],
            'status' => 'active',
            'religion' => $validated['religion'],
            'ethnicity' => $validated['ethnicity'],
            'emergencyContactNo' => $validated['emergency_contact_no'] ?? null,
        ]);

        $household = $resident->family->household ?? null;
        $purokId = $household->purok_id ?? null;

        // Create residence history
        ResidenceHistory::create([
            'resident_id' => $resident->id,
            'purok_id' => $purokId,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
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
            'user_id' => auth()->id(),
            'module_id' => 2,
            'activity' => 'Added a new resident: ' . $residentName . ' in ' . ucfirst($purokName) . '.',
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Resident created successfully',
            'data' => $resident
        ]);
    }


    public function updateResident(Request $request, $id)
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
        
        try {
            // Find the resident
            $resident = Resident::findOrFail($id);
            
            \Log::info('Resident found: ' . $resident->firstName . ' ' . $resident->lastName);
            
            // Map the incoming data to database columns
            $updateData = [
                'firstName' => $request->input('first_name'),
                'lastName' => $request->input('last_name'),
                'middleName' => $request->input('middle_name'),
                'suffix' => $request->input('suffix'),
                'contact_no' => $request->input('contact_no'),
                'sex' => $request->input('sex'),
                'birthdate' => $request->input('birthdate'),
                'civil_status' => $request->input('civil_status'),
                'religion' => $request->input('religion'),
                'ethnicity' => $request->input('ethnicity'),
                'employment_status' => $request->input('employment_status'),
                'is_pwd' => $request->input('is_pwd') ? 1 : 0,
                'pwd_id' => $request->input('pwd_id'),
                'is_indigenous' => $request->input('is_indigenous') ? 1 : 0,
                'if_solo_parent' => $request->input('is_solo_parent') ? 1 : 0,
                'if_philhealth' => $request->input('is_philhealth_member') ? 1 : 0,
                'philhealth_no' => $request->input('philhealth_no'),
                'emergencyContactNo' => $request->input('emergency_contact_no'),
                'educational_attainment' => $request->input('educational_attainment'),
                'status' => $request->input('status'),
            ];
            
            \Log::info('Mapped update data:', $updateData);
            
            // Update the resident
            $resident->update($updateData);
            
            \Log::info('✅ Resident updated successfully');
            
            // Reload the resident with relationships
            $resident->load(['family.household.purok', 'basicHealthRecord']);
            
            // ✅ Create activity log
            $residentName = trim($resident->firstName . ' ' . ($resident->middleName ? $resident->middleName . ' ' : '') . $resident->lastName . ($resident->suffix ? ' ' . $resident->suffix : ''));
            $purokName = $resident->family->household->purok->name ?? 'Unknown Purok';
            
            ActivityLog::create([
                'user_id'   => auth()->id(),
                'module_id' => 2, // Module ID for residents
                'activity'  => 'Updated resident: ' . $residentName . ' in ' . ucfirst($purokName) . '.',
            ]);
            
            \Log::info('Activity log created for: ' . $residentName);
            \Log::info('================================');
            
            return response()->json([
                'success' => true,
                'message' => 'Resident updated successfully',
                'resident' => $resident
            ], 200);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('❌ Resident not found with ID: ' . $id);
            
            return response()->json([
                'success' => false,
                'message' => 'Resident not found'
            ], 404);
            
        } catch (\Exception $e) {
            \Log::error('❌ Error updating resident: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update resident',
                'error' => $e->getMessage()
            ], 500);
        }
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


    public function storeOrUpdateResidentSync(Request $request)
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
                'residents' => 'required|array',
                'residents.*.local_id' => 'required|integer',
                'residents.*.client_uuid' => 'required|string',
                'residents.*.family_server_id' => 'required|exists:families,id',
                'residents.*.firstName' => 'required|string|max:255',
                'residents.*.lastName' => 'required|string|max:255',
                'residents.*.middleName' => 'nullable|string|max:255',
                'residents.*.suffix' => 'nullable|string|max:50',
                'residents.*.birthdate' => 'required|string',
                'residents.*.sex' => 'required|string',
                'residents.*.contact_no' => 'nullable|string|max:20',
                'residents.*.philhealth_no' => 'nullable|string|max:255',
                'residents.*.civil_status' => 'required|string|max:255',
                'residents.*.religion' => 'required|string|max:255',
                'residents.*.ethnicity' => 'required|string',
                'residents.*.educational_attainment' => 'nullable|string|max:255',
                'residents.*.employment_status' => 'nullable|string|max:255',
                'residents.*.is_pwd' => 'nullable|integer',
                'residents.*.pwd_id' => 'nullable|string|max:100',
                'residents.*.is_indigenous' => 'nullable|integer',
                'residents.*.is_philhealth' => 'nullable|integer',
                'residents.*.is_solo_parent' => 'nullable|integer',
                'residents.*.emergencyContactNo' => 'nullable|string|max:20',
                'residents.*.family_relationship' => 'nullable|string|max:255',
                'residents.*.status' => 'required|string',
                'residents.*.updated_at' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $syncedResidents = [];

            DB::transaction(function () use ($validated, $user, &$syncedResidents) {
                foreach ($validated['residents'] as $residentData) {
                    $existingResident = Resident::where('client_uuid', $residentData['client_uuid'])->first();
                    
                    // Get the target family
                    $newFamily = Family::find($residentData['family_server_id']);
                    $newHousehold = $newFamily->household;
                    $newPurokId = $newHousehold->purok_id;

                    $birthdate = $this->convertToMySQLDate($residentData['birthdate']);
                    
                    if ($existingResident) {
                        // Check for conflict resolution (Last Write Wins)
                        $serverUpdatedAt = Carbon::parse($existingResident->updated_at);
                        $clientUpdatedAt = Carbon::parse($residentData['updated_at']);

                        if ($serverUpdatedAt->greaterThan($clientUpdatedAt)) {
                            // Server has newer data - skip update
                            $syncedResidents[] = [
                                'local_id' => $residentData['local_id'],
                                'server_id' => $existingResident->id,
                                'updated_at' => $existingResident->updated_at->toIso8601String(),
                                'is_household_head' => $this->isHouseholdHead($existingResident->id),
                            ];
                            continue;
                        }

                        // Check if family (and thus purok) has changed
                        $oldFamily = $existingResident->family;
                        $oldHousehold = $oldFamily->household;
                        $oldPurokId = $oldHousehold->purok_id;
                        

                        if ($oldPurokId != $newPurokId) {
                            // Purok changed - mark previous history as "moved"
                            ResidenceHistory::where('resident_id', $existingResident->id)
                                ->where('status', 'active')
                                ->update(['status' => 'moved']);

                            // Create new history record for the new location
                            ResidenceHistory::create([
                                'resident_id' => $existingResident->id,
                                'purok_id' => $newPurokId,
                                'status' => 'active',
                            ]);

                            // Log the move activity
                            $oldPurok = Purok::find($oldPurokId);
                            $newPurok = Purok::find($newPurokId);
                            $residentName = trim($residentData['firstName'] . ' ' . ($residentData['middleName'] ?? '') . ' ' . $residentData['lastName']);
                            
                            ActivityLog::create([
                                'user_id' => $user->id,
                                'module_id' => 2,
                                'activity' => 'Resident ' . $residentName . ' moved from Purok ' . ucfirst($oldPurok->name) . 
                                            ' to Purok ' . ucfirst($newPurok->name) . '.',
                            ]);
                        } elseif ($oldFamily->id != $newFamily->id) {
                            // Same purok but different family - update history
                            ResidenceHistory::where('resident_id', $existingResident->id)
                                ->where('status', 'active')
                                ->update(['status' => 'inactive']);

                            ResidenceHistory::create([
                                'resident_id' => $existingResident->id,
                                'purok_id' => $newPurokId,
                                'status' => 'active',
                            ]);
                        }

                        // Update the resident record
                        $existingResident->update([
                            'family_id' => $residentData['family_server_id'],
                            'firstName' => $residentData['firstName'],
                            'lastName' => $residentData['lastName'],
                            'middleName' => $residentData['middleName'],
                            'suffix' => $residentData['suffix'],
                            'birthdate' => $birthdate,
                            'sex' => $residentData['sex'],
                            'contact_no' => $residentData['contact_no'],
                            'philhealth_no' => $residentData['philhealth_no'],
                            'civil_status' => $residentData['civil_status'],
                            'religion' => $residentData['religion'],
                            'ethnicity' => $residentData['ethnicity'],
                            'educational_attainment' => $residentData['educational_attainment'],
                            'emergencyContactNo' => $residentData['emergencyContactNo'],
                            'is_pwd' => $residentData['is_pwd'] ?? 0,
                            'pwd_id' => $residentData['pwd_id'],
                            'is_indigenous' => $residentData['is_indigenous'] ?? 0,
                            'if_philhealth' => $residentData['is_philhealth'] ?? 0,
                            'if_solo_parent' => $residentData['is_solo_parent'] ?? 0,
                            'employment_status' => $residentData['employment_status'] ?? 'not-applicable',
                            'status' => $residentData['status'],
                            'updated_at' => $residentData['updated_at'],
                        ]);

                        $syncedResidents[] = [
                            'local_id' => $residentData['local_id'],
                            'server_id' => $existingResident->id,
                            'updated_at' => $existingResident->updated_at->toIso8601String(),
                            'is_household_head' => $this->isHouseholdHead($existingResident->id),
                        ];
                    } else {
                        // New resident - create it
                        $resident = Resident::create([
                            'client_uuid' => $residentData['client_uuid'],
                            'family_id' => $residentData['family_server_id'],
                            'added_by' => $user->id,
                            'firstName' => $residentData['firstName'],
                            'lastName' => $residentData['lastName'],
                            'middleName' => $residentData['middleName'],
                            'suffix' => $residentData['suffix'],
                            'birthdate' => $birthdate,
                            'sex' => $residentData['sex'],
                            'contact_no' => $residentData['contact_no'],
                            'philhealth_no' => $residentData['philhealth_no'],
                            'civil_status' => $residentData['civil_status'],
                            'religion' => $residentData['religion'],
                            'ethnicity' => $residentData['ethnicity'],
                            'educational_attainment' => $residentData['educational_attainment'],
                            'emergencyContactNo' => $residentData['emergencyContactNo'],
                            'is_pwd' => $residentData['is_pwd'] ?? 0,
                            'pwd_id' => $residentData['pwd_id'],
                            'is_indigenous' => $residentData['is_indigenous'] ?? 0,
                            'if_philhealth' => $residentData['is_philhealth'] ?? 0,
                            'if_solo_parent' => $residentData['is_solo_parent'] ?? 0,
                            'employment_status' => $residentData['employment_status'] ?? 'not-applicable',
                            'status' => $residentData['status'],
                            'created_at' => now(),
                            'updated_at' => $residentData['updated_at'],
                        ]);

                        // Create initial residence history
                        ResidenceHistory::create([
                            'resident_id' => $resident->id,
                            'purok_id' => $newPurokId,
                            'status' => 'active',
                        ]);

                   
                        // Check age for PhilPEN enrollment
                        $age = Carbon::parse($residentData['birthdate'])->age;
                        if ($age >= 20 && $age <= 59) {
                            $this->enrollPhilpen($resident->id);
                        }

                        // Log activity
                        $purok = Purok::find($newPurokId);
                        $residentName = trim($residentData['firstName'] . ' ' . ($residentData['middleName'] ?? '') . ' ' . $residentData['lastName']);
                        
                        ActivityLog::create([
                            'user_id' => $user->id,
                            'module_id' => 2,
                            'activity' => 'Added a new resident: ' . $residentName . ' in ' . ucfirst($purok->name) . '.',
                        ]);

                        $syncedResidents[] = [
                            'local_id' => $residentData['local_id'],
                            'server_id' => $resident->id,
                            'updated_at' => $resident->updated_at->toIso8601String(),
                            'is_household_head' => false,
                        ];
                    }
                }
            });

            return response()->json([
                'message' => 'Residents synced successfully!',
                'residents' => $syncedResidents,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Resident sync error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function convertToMySQLDate($dateString)
    {
        try {
            // Try parsing as ISO8601 first (from Flutter)
            if (strpos($dateString, 'T') !== false) {
                $date = Carbon::parse($dateString);
                return $date->format('Y-m-d');
            }
            
            // Check for MM/DD/YYYY format
            if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dateString)) {
                $date = Carbon::createFromFormat('m/d/Y', $dateString);
                if ($date && $date->format('m/d/Y') === $dateString) {
                    return $date->format('Y-m-d');
                }
            }
            
            // Already in YYYY-MM-DD or parseable format
            $date = Carbon::parse($dateString);
            return $date->format('Y-m-d');
            
        } catch (\Exception $e) {
            \Log::warning("Date conversion failed for: {$dateString}");
            return null;
        }
    }

    private function isHouseholdHead($residentId)
    {
        return Household::where('head_id', $residentId)->exists();
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
