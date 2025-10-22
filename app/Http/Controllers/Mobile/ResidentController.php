<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        
        // Base resident query
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
                    $fullName = $firstName . ' ' . $middleName . ' ' . $lastName;
                    
                    return str_contains($firstName, $searchTerm) ||
                        str_contains($lastName, $searchTerm) ||
                        str_contains($middleName, $searchTerm) ||
                        str_contains($fullName, $searchTerm);
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
            $residents = $residentsQuery->paginate(20);
        }
        
        return response()->json([
            'success' => true,
            'data' => $residents,
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
}
