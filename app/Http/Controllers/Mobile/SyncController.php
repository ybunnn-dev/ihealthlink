<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Models\Resident;
use App\Models\ResidenceHistory;
use App\Models\BasicHealthRecord;
use App\Models\HealthSigns;
use App\Models\ResidentMedicalHistory;
use App\Models\ResidentFamilyHistory;
use App\Models\NcdRiskFactor;
use App\Models\RiskAssessment;
use App\Models\PhilpenManagement;
use App\Models\Family;
use App\Models\Household;
use App\Models\Barangay;
use App\Models\ActivityLog;
use App\Models\HealthProgram;
use App\Models\EnrolledResident;
use App\Models\Purok;
use App\Models\Consultation;
use App\Models\ConsultationData;

class SyncController extends Controller
{

    public function storeOrUpdateBasicHealthRecordSync(Request $request)
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
                'basic_health_records' => 'required|array',
                'basic_health_records.*.local_id' => 'required|integer',
                'basic_health_records.*.uuid' => 'required|string',
                'basic_health_records.*.resident_server_id' => 'required|exists:residents,id',
                'basic_health_records.*.weight' => 'nullable|numeric',
                'basic_health_records.*.height' => 'nullable|numeric',
                'basic_health_records.*.weight_grams' => 'nullable|integer',
                'basic_health_records.*.status' => 'required|string',
                'basic_health_records.*.health_records' => 'nullable|string',
                'basic_health_records.*.waist_circumference' => 'nullable|numeric',
                'basic_health_records.*.systolic_pressure' => 'nullable|integer',
                'basic_health_records.*.diastolic_pressure' => 'nullable|integer',
                'basic_health_records.*.is_pregnant' => 'nullable|integer',
                'basic_health_records.*.is_lactating' => 'nullable|integer',
                'basic_health_records.*.updated_at' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $syncedRecords = [];

            DB::transaction(function () use ($validated, $user, &$syncedRecords) {
                foreach ($validated['basic_health_records'] as $recordData) {
                    $existingRecord = BasicHealthRecord::where('uuid', $recordData['uuid'])->first();

                    if ($existingRecord) {
                        // Check for conflict resolution (Last Write Wins)
                        $serverUpdatedAt = Carbon::parse($existingRecord->updated_at);
                        $clientUpdatedAt = Carbon::parse($recordData['updated_at']);

                        if ($serverUpdatedAt->greaterThan($clientUpdatedAt)) {
                            // Server has newer data - skip update
                            $syncedRecords[] = [
                                'local_id' => $recordData['local_id'],
                                'server_id' => $existingRecord->id,
                                'updated_at' => $existingRecord->updated_at->toIso8601String(),
                            ];
                            continue;
                        }

                        // Update the existing record
                        $existingRecord->update([
                            'resident_id' => $recordData['resident_server_id'],
                            'weight' => $recordData['weight'],
                            'height' => $recordData['height'],
                            'weight_grams' => $recordData['weight_grams'],
                            'status' => $recordData['status'],
                            'health_records' => $recordData['health_records'],
                            'waist_circumference' => $recordData['waist_circumference'],
                            'systolic_pressure' => $recordData['systolic_pressure'],
                            'diastolic_pressure' => $recordData['diastolic_pressure'],
                            'is_pregnant' => $recordData['is_pregnant'] ?? 0,
                            'is_lactating' => $recordData['is_lactating'] ?? 0,
                            'updated_at' => $recordData['updated_at'],
                        ]);

                        // Log the update
                        $resident = Resident::find($recordData['resident_server_id']);
                        $residentName = $resident ? trim($resident->firstName . ' ' . $resident->lastName) : 'Unknown';
                        
                        ActivityLog::create([
                            'user_id' => $user->id,
                            'module_id' => 2, // Health records module
                            'activity' => 'Updated basic health record for ' . $residentName . '.',
                        ]);

                        $syncedRecords[] = [
                            'local_id' => $recordData['local_id'],
                            'server_id' => $existingRecord->id,
                            'updated_at' => $existingRecord->updated_at->toIso8601String(),
                        ];
                    } else {
                        // New record - create it
                        $record = BasicHealthRecord::create([
                            'uuid' => $recordData['uuid'],
                            'resident_id' => $recordData['resident_server_id'],
                            'weight' => $recordData['weight'],
                            'height' => $recordData['height'],
                            'weight_grams' => $recordData['weight_grams'],
                            'status' => $recordData['status'],
                            'health_records' => $recordData['health_records'],
                            'waist_circumference' => $recordData['waist_circumference'],
                            'systolic_pressure' => $recordData['systolic_pressure'],
                            'diastolic_pressure' => $recordData['diastolic_pressure'],
                            'is_pregnant' => $recordData['is_pregnant'] ?? 0,
                            'is_lactating' => $recordData['is_lactating'] ?? 0,
                            'created_at' => now(),
                            'updated_at' => $recordData['updated_at'],
                        ]);

                        // Log the creation
                        $resident = Resident::find($recordData['resident_server_id']);
                        $residentName = $resident ? trim($resident->firstName . ' ' . $resident->lastName) : 'Unknown';
                        
                        ActivityLog::create([
                            'user_id' => $user->id,
                            'module_id' => 2,
                            'activity' => 'Created basic health record for ' . $residentName . '.',
                        ]);

                        $syncedRecords[] = [
                            'local_id' => $recordData['local_id'],
                            'server_id' => $record->id,
                            'updated_at' => $record->updated_at->toIso8601String(),
                        ];
                    }
                }
            });

            return response()->json([
                'message' => 'Basic health records synced successfully!',
                'basic_health_records' => $syncedRecords,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Basic health record sync error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeConsultationSync(Request $request)
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
                'consultations' => 'required|array',
                'consultations.*.local_id' => 'required|integer',
                'consultations.*.uuid' => 'required|string',
                'consultations.*.resident_server_id' => 'required|exists:residents,id',
                'consultations.*.status' => 'required|string',
                'consultations.*.schedule_extension_days' => 'nullable|integer',
                'consultations.*.consultation_title' => 'nullable|string',
                'consultations.*.chief_complaint' => 'nullable|string',
                'consultations.*.treatment' => 'nullable|string',
                'consultations.*.birthweight' => 'nullable|integer',
                'consultations.*.weight' => 'nullable|numeric',
                'consultations.*.height' => 'nullable|numeric',
                'consultations.*.bp_systolic' => 'nullable|integer',
                'consultations.*.bp_diastolic' => 'nullable|integer',
                'consultations.*.rr' => 'nullable|integer',
                'consultations.*.temperature' => 'nullable|numeric',
                'consultations.*.pr' => 'nullable|integer',
                'consultations.*.is_lactating' => 'nullable|integer',
                'consultations.*.is_pregnant' => 'nullable|integer',
                'consultations.*.created_at' => 'required|string',
                'consultations.*.updated_at' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $syncedConsultations = [];

            DB::transaction(function () use ($validated, $user, &$syncedConsultations) {
                foreach ($validated['consultations'] as $consultationData) {
                    // Check if consultation already exists by UUID
                    $existingConsultation = Consultation::where('uuid', $consultationData['uuid'])->first();

                    if ($existingConsultation) {
                        // Consultation already exists - this is a duplicate
                        // Don't create new one, just return existing server_id
                        $syncedConsultations[] = [
                            'local_id' => $consultationData['local_id'],
                            'server_id' => $existingConsultation->id,
                            'updated_at' => $existingConsultation->updated_at->toIso8601String(),
                            'was_newly_created' => false,  // Flag to indicate duplicate
                        ];
                        
                        \Log::warning("Duplicate consultation detected: UUID {$consultationData['uuid']} already exists as ID {$existingConsultation->id}");
                        continue;
                    }

                    // New consultation - create it
                    $consultation = Consultation::create([
                        'uuid' => $consultationData['uuid'],
                        'resident_id' => $consultationData['resident_server_id'],
                        'consultation_date' => $consultationData['created_at'],  // Use created_at as consultation_date
                        'status' => $consultationData['status'],
                        'is_pregnant' => $consultationData['is_pregnant'] ?? 0,
                        'is_lactating' => $consultationData['is_lactating'] ?? 0,
                        'updated_by' => $user->id,
                        'created_at' => $consultationData['created_at'],
                        'updated_at' => $consultationData['updated_at'],
                    ]);

                    // Create consultation data
                    ConsultationData::create([
                        'consultation_id' => $consultation->id,
                        'chief_complaint' => $consultationData['chief_complaint'],
                        'treatment' => $consultationData['treatment'],
                        'weight' => $consultationData['weight'],
                        'height' => $consultationData['height'],
                        'bp_systolic' => $consultationData['bp_systolic'],
                        'bp_diastolic' => $consultationData['bp_diastolic'],
                        'temperature' => $consultationData['temperature'],
                        'pr' => $consultationData['pr'],
                        'rr' => $consultationData['rr'],
                    ]);

                    // Update basic health record (only non-null values)
                    $resident = Resident::find($consultationData['resident_server_id']);
                    if ($resident) {
                        $healthRecord = BasicHealthRecord::firstOrNew(['resident_id' => $resident->id]);

                        // Only update if values are provided
                        if ($consultationData['weight'] !== null) {
                            $healthRecord->weight = $consultationData['weight'];
                        }
                        if ($consultationData['height'] !== null) {
                            $healthRecord->height = $consultationData['height'];
                        }
                        if ($consultationData['bp_systolic'] !== null) {
                            $healthRecord->systolic_pressure = $consultationData['bp_systolic'];
                        }
                        if ($consultationData['bp_diastolic'] !== null) {
                            $healthRecord->diastolic_pressure = $consultationData['bp_diastolic'];
                        }

                        // Always update pregnant/lactating status
                        $healthRecord->is_pregnant = $consultationData['is_pregnant'] ?? 0;
                        $healthRecord->is_lactating = $consultationData['is_lactating'] ?? 0;

                        $healthRecord->save();
                    }

                    // Log activity
                    $residentName = $resident ? trim($resident->firstName . ' ' . $resident->lastName) : 'Unknown';
                    
                    ActivityLog::create([
                        'user_id' => $user->id,
                        'module_id' => 7,  // Consultation module
                        'activity' => "Synced consultation for {$residentName}.",
                    ]);

                    $syncedConsultations[] = [
                        'local_id' => $consultationData['local_id'],
                        'server_id' => $consultation->id,
                        'updated_at' => $consultation->updated_at->toIso8601String(),
                        'was_newly_created' => true,  // Flag to indicate new creation
                    ];

                    \Log::info("New consultation created: UUID {$consultationData['uuid']} → ID {$consultation->id}");
                }
            });

            return response()->json([
                'message' => 'Consultations synced successfully!',
                'consultations' => $syncedConsultations,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Consultation sync error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function syncPhilpenAssessments(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Determine personnel type
            $personnel = $user->bhwWeb ?? $user->bhw ?? $user->midwife;

            if (!$personnel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No associated personnel found for this user.'
                ], 404);
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'assessments' => 'required|array',
                'assessments.*.local_id' => 'required|integer',
                'assessments.*.consultation_id' => 'required|exists:consultations,id',
                'assessments.*.uuid' => 'required|string',
                'assessments.*.health_signs' => 'nullable|array',
                'assessments.*.medical_history' => 'nullable|array',
                'assessments.*.family_history' => 'nullable|array',
                'assessments.*.ncd_risk_factors' => 'nullable|array',
                'assessments.*.risk_assessment' => 'nullable|array',
                'assessments.*.management' => 'nullable|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $syncedAssessments = [];

            DB::transaction(function () use ($validated, $user, &$syncedAssessments) {
                foreach ($validated['assessments'] as $assessmentData) {
                    $consultationId = $assessmentData['consultation_id'];
                    
                    // Update consultation status to completed
                    Consultation::where('id', $consultationId)->update(['status' => 'completed']);

                    $serverIds = [
                        'local_id' => $assessmentData['local_id'],
                        'consultation_id' => $consultationId,
                        'server_id' => $consultationId,
                    ];

                    // 1. Update or Create Health Signs
                    if (isset($assessmentData['health_signs'])) {
                        $healthSigns = HealthSigns::updateOrCreate(
                            ['consultation_id' => $consultationId],
                            array_merge($assessmentData['health_signs'], ['updated_at' => now()])
                        );
                        $serverIds['health_signs_server_id'] = $healthSigns->id;
                    }

                    // 2. Update or Create Medical History
                    if (isset($assessmentData['medical_history'])) {
                        $medicalHistory = ResidentMedicalHistory::updateOrCreate(
                            ['consultation_id' => $consultationId],
                            array_merge($assessmentData['medical_history'], ['updated_at' => now()])
                        );
                        $serverIds['medical_history_server_id'] = $medicalHistory->id;
                    }

                    // 3. Update or Create Family History
                    if (isset($assessmentData['family_history'])) {
                        $familyHistory = ResidentFamilyHistory::updateOrCreate(
                            ['consultation_id' => $consultationId],
                            array_merge($assessmentData['family_history'], ['updated_at' => now()])
                        );
                        $serverIds['family_history_server_id'] = $familyHistory->id;
                    }

                    // 4. Update or Create NCD Risk Factors
                    if (isset($assessmentData['ncd_risk_factors'])) {
                        $ncdRiskFactors = NcdRiskFactor::updateOrCreate(
                            ['consultation_id' => $consultationId],
                            array_merge($assessmentData['ncd_risk_factors'], ['updated_at' => now()])
                        );
                        $serverIds['ncd_risk_factors_server_id'] = $ncdRiskFactors->id;
                    }

                    // 5. Update or Create Risk Assessment
                    if (isset($assessmentData['risk_assessment'])) {
                        $riskAssessment = RiskAssessment::updateOrCreate(
                            ['consultation_id' => $consultationId],
                            array_merge($assessmentData['risk_assessment'], ['updated_at' => now()])
                        );
                        $serverIds['risk_assessment_server_id'] = $riskAssessment->id;
                    }

                    // 6. Update or Create Management
                    if (isset($assessmentData['management'])) {
                        $managementData = $assessmentData['management'];
                        
                        // Convert follow_up_date if it's in MM/DD/YYYY format
                        if (isset($managementData['follow_up_date']) && !empty($managementData['follow_up_date'])) {
                            $followUpDate = $managementData['follow_up_date'];
                            
                            // Check if date contains slashes (MM/DD/YYYY format)
                            if (strpos($followUpDate, '/') !== false) {
                                try {
                                    $date = \Carbon\Carbon::createFromFormat('m/d/Y', $followUpDate);
                                    // Verify the date was parsed correctly
                                    if ($date && $date->format('m/d/Y') === $followUpDate) {
                                        $managementData['follow_up_date'] = $date->format('Y-m-d');
                                    }
                                } catch (\Exception $e) {
                                    // If conversion fails, set to null
                                    $managementData['follow_up_date'] = null;
                                }
                            }
                        }
                        
                        $management = PhilpenManagement::updateOrCreate(
                            ['consultation_id' => $consultationId],
                            array_merge($managementData, ['updated_at' => now()])
                        );
                        $serverIds['management_server_id'] = $management->id;
                    }


                    // Log activity
                    $consultation = Consultation::find($consultationId);
                    $resident = $consultation->resident;
                    $residentName = trim($resident->firstName . ' ' . $resident->lastName);
                    
                    ActivityLog::create([
                        'user_id' => $user->id,
                        'module_id' => 7,
                        'activity' => "Completed PhilPEN assessment for {$residentName}.",
                    ]);

                    $syncedAssessments[] = $serverIds;
                }
            });

            return response()->json([
                'message' => 'PhilPEN assessments synced successfully!',
                'assessments' => $syncedAssessments,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('PhilPEN sync error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function fetchAllByPuroks(Request $request)
    {
        $purokIds = $request->input('puroks', []);

        if (empty($purokIds)) {
            return response()->json(['error' => 'No purok IDs provided.'], 400);
        }

        // Fetch all relevant data filtered by purok_id through relationships
        return response()->json([
            // 1️⃣ Households directly under these puroks
            'households' => Household::whereIn('purok_id', $purokIds)->get(),

            // 2️⃣ Families whose households belong to those puroks
            'families' => Family::whereHas('household', function ($q) use ($purokIds) {
                $q->whereIn('purok_id', $purokIds);
            })->get(),

            // 3️⃣ Residents whose families’ households belong to those puroks
            'residents' => Resident::whereHas('family.household', function ($q) use ($purokIds) {
                    $q->whereIn('purok_id', $purokIds);
                })
                ->with('basicHealthRecord')
                ->get(),
        ]);
    }
}
