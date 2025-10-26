<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Resident;
use App\Models\Family;
use App\Models\Household;
use App\Models\Barangay;
use App\Models\ResidenceHistory;
use App\Models\HealthProgram;
use App\Helpers\ProjectCrypt;
use App\Models\ActivityLog;
use App\Models\EnrolledResident;
use App\Models\Consultation;
use App\Models\Notification;  
use App\Models\Personnel; 
use App\Models\ResidentMedicalHistory;
use App\Models\ResidentFamilyHistory;
use App\Models\HealthSigns;
use App\Models\RiskAssessment;
use App\Models\NcdRiskFactor;
use App\Models\PhilpenManagement;
use Illuminate\Support\Str;

use App\Services\Notifications\FireBase;  
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;


class PhilpenController extends Controller
{
    public function createNewScheds(Request $request)
    {
        $validated = $request->validate([
            'consultation_date' => 'required|date',
        ]);

        $user = Auth::user();
        $personnel = $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $brgyId = $personnel->brgy_id;

        // Use database transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Step 1: Mark all pending consultations as completed
            $updatedCount = Consultation::whereHas('enrolledResident', function($query) use ($brgyId) {
                                $query->where('status', 'active')
                                    ->whereHas('resident', function($query) use ($brgyId) {
                                        $query->where('status', 'active')
                                            ->whereHas('family', function($query) use ($brgyId) {
                                                $query->where('status', 'active')
                                                    ->whereHas('household', function($query) use ($brgyId) {
                                                        $query->where('status', 'active')
                                                            ->whereHas('purok', function($query) use ($brgyId) {
                                                                $query->where('brgy_id', $brgyId)
                                                                    ->where('status', 'active');
                                                            });
                                                    });
                                            });
                                    })
                                    ->whereHas('program', function($query) {
                                        $query->where('category', 'philpen_tcl')
                                            ->where('status', 'active');
                                    });
                            })
                            ->where('status', 'pending')
                            ->update([
                                'status' => 'completed',
                                'updated_at' => now()
                            ]);

            // Step 2: Get all enrolled residents in the current barangay for philpen_tcl
            $enrolledResidents = EnrolledResident::where('status', 'active')
                ->whereHas('resident', function($query) use ($brgyId) {
                    $query->where('status', 'active')
                        ->whereHas('family', function($query) use ($brgyId) {
                            $query->where('status', 'active')
                                ->whereHas('household', function($query) use ($brgyId) {
                                    $query->where('status', 'active')
                                        ->whereHas('purok', function($query) use ($brgyId) {
                                            $query->where('brgy_id', $brgyId)
                                                ->where('status', 'active');
                                        });
                                });
                        });
                })
                ->whereHas('program', function($query) {
                    $query->where('category', 'philpen_tcl')
                        ->where('status', 'active');
                })
                ->get();

            // Step 3: Create new consultations for all enrolled residents
            $newConsultations = [];
            $consultationTimestamp = now();
            
            foreach ($enrolledResidents as $enrolledResident) {
                $newConsultations[] = [
                    'uuid' => Str::uuid()->toString(),
                    'consultation_title' => 'Scheduled Return',
                    'enrolled_resident_id' => $enrolledResident->id,
                    'resident_id' => $enrolledResident->resident_id,
                    'consultation_date' => $validated['consultation_date'],
                    'status' => 'pending',
                    'created_at' => $consultationTimestamp,
                    'updated_at' => $consultationTimestamp
                ];
            }

            // Bulk insert new consultations
            $createdConsultationsCount = 0;
            if (!empty($newConsultations)) {
                Consultation::insert($newConsultations);
                $createdConsultationsCount = count($newConsultations);
                
                // Step 4: Get the newly created consultations to create related PhilPEN records
                $newlyCreatedConsultations = Consultation::where('created_at', $consultationTimestamp)
                    ->whereIn('resident_id', $enrolledResidents->pluck('resident_id'))
                    ->where('status', 'pending')
                    ->get();

                // Step 5: Create empty PhilPEN records for EACH consultation
                foreach ($newlyCreatedConsultations as $consultation) {
                    $residentId = $consultation->resident_id;
                    $consultationId = $consultation->id;

                    // Create Health Signs (per consultation to track over time)
                    HealthSigns::create([
                        'consultation_id' => $consultationId,  // ← Add consultation_id
                        'chest_pain' => null,
                        'difficulty_in_breathing' => null,
                        'loss_of_consciousness' => null,
                        'numbness_of_arm' => null,
                        'act_of_self_harm_or_suicide' => null,
                        'agitated_or_aggressive_behavior' => null,
                        'severe_injuries' => null,
                        'slurred_speech' => null,
                        'facial_asymmetry' => null,
                        'chest_retractions' => null,
                        'seizure_or_convulsion' => null,
                        'disoriented_as_to_time_place_or_person' => null,
                        'eye_injury' => null,
                    ]);

                    // Create Family History (per consultation to track over time)
                    ResidentFamilyHistory::create([
                        'consultation_id' => $consultationId,  // ← Add consultation_id
                        'hypertension' => null,
                        'heart_diseases' => null,
                        'copd' => null,
                        'tuberculosis_last_five_years' => null,
                        'stroke' => null,
                        'diabetes_mellitus' => null,
                        'cancer' => null,
                        'asthma' => null,
                        'kidney_disorders' => null,
                        'premature_coronary_or_vascular_disease' => null,
                        'mental_neurological_substance_abuse_disorders' => null,
                    ]);

                    // Create Medical History (per consultation to track over time)
                    ResidentMedicalHistory::create([
                        'consultation_id' => $consultationId,  // ← Add consultation_id
                        'hypertension' => null,
                        'heart_diseases' => null,
                        'copd' => null,
                        'surgical_history' => null,
                        'allergies' => null,
                        'diabetes' => null,
                        'cancer' => null,
                        'asthma' => null,
                        'kidney_disorders' => null,
                        'vision_problems' => null,
                        'thyroid_disorders' => null,
                        'mental_neuro_substance_disorders' => null,
                    ]);

                    // Create Risk Assessment (per consultation to track over time)
                    RiskAssessment::create([
                        'consultation_id' => $consultationId,  // ← Add consultation_id
                        'polyphagia' => null,
                        'polydipsia' => null,
                        'polyuria' => null,
                        'breathlessness' => null,
                        'chronic_cough' => null,
                        'sputum_production' => null,
                        'wheezing' => null,
                        'fbs_result' => null,
                        'rbs_result' => null,
                        'total_cholesterol' => null,
                        'hdl' => null,
                        'ldl' => null,
                        'vldl' => null,
                        'triglyceride' => null,
                        'protein' => null,
                        'ketones' => null,
                        'blood_sugar_date_taken' => null,
                        'lipid_profile_date_taken' => null,
                        'urinalysis_date_taken' => null,
                    ]);

                    // Create NCD Risk Factor (per consultation)
                    NcdRiskFactor::create([
                        'consultation_id' => $consultationId,
                        'tobacco_use' => null,
                        'alcohol_intake' => null,
                        'caffeine_intake' => null,
                        'high_fat_high_salt_food_intake' => null,
                        'street_foods_intake' => null,
                        'high_sugar_foods_intake' => null,
                        'number_of_drinks_last_year' => null,
                        'hours_of_activity_weekly' => null,
                        'weight' => null,
                        'height' => null,
                        'waist_circumference' => null,
                        'systolic_pressure' => null,
                        'diastolic_pressure' => null,
                    ]);

                    // Create PhilPEN Management (per consultation)
                    PhilpenManagement::create([
                        'consultation_id' => $consultationId,
                        'is_lifestyle_modification' => null,
                        'is_anti_hypertensive' => null,
                        'is_insulin' => null,
                        'follow_up_date' => null,
                        'remarks' => null,
                    ]);
                }

                \Log::info("Created PhilPEN records for {$createdConsultationsCount} consultations");
            }

            DB::commit();

            $this->notifyBarangayPersonnel($brgyId);

            // Log the activity
            ActivityLog::create([
                'user_id'   => $user->id,
                'module_id' => 5,
                'activity'  => 'Created new PhilPEN scheduled consultations with empty assessment records.',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Consultation date logged successfully.',
                'data' => [
                    'consultation_date' => $validated['consultation_date'],
                    'previous_consultations_completed' => $updatedCount,
                    'new_consultations_created' => $createdConsultationsCount,
                    'philpen_records_created' => $createdConsultationsCount * 5  // 5 types of records per consultation
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('Failed to create consultations:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create consultations.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    private function notifyBarangayPersonnel($brgyId)
    {
        // Get all active personnel in this barangay
        $personnel = Personnel::where('brgy_id', $brgyId)
            ->where('status', 'active')
            ->with('user')
            ->get();


        $notificationSubject = 'New PhilPEN Consulations';
        $notificationMessage = "A new scheduled activity for PhilPEN Risk Assessment has been created. Please download the new PhilPEN consultations.";

        $notifiedCount = 0;

        foreach ($personnel as $person) {
            if ($person->user) {
                // Create notification in database (shows in UI bell icon)
                Notification::create([
                    'user_id' => $person->user->id,
                    'subject' => $notificationSubject,
                    'message' => $notificationMessage,
                    'module_id' => 5,
                    'is_read' => false
                ]);

                // Send push notification if user has FCM token
                if ($person->user->fcm_token) {
                    try {
                        FireBase::send(
                            $notificationSubject,
                            $notificationMessage,
                            [$person->user->fcm_token]
                        );
                        $notifiedCount++;
                    } catch (\Exception $e) {
                        Log::error('FCM Error for user ' . $person->user->id . ': ' . $e->getMessage());
                    }
                }
            }
        }
    }
  
    public function countIncomplete(){
        $user = Auth::user();

        // Identify which type of personnel is logged in
        $personnel = $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        \Log::info($personnel);
        
        $brgyId = $personnel->brgy_id;

        // Count all pending consultations for enrolled residents in philpen_tcl program
        $pendingCount = Consultation::whereHas('enrolledResident', function($query) use ($brgyId) {
                            $query->where('status', 'active')
                                ->whereHas('resident', function($query) use ($brgyId) {  // Add use ($brgyId) here
                                    $query->where('status', 'active')
                                            ->whereHas('family', function($query) use ($brgyId) {  // Add use ($brgyId) here
                                                $query->where('status', 'active')
                                                    ->whereHas('household', function($query) use ($brgyId) {  // Add use ($brgyId) here
                                                        $query->where('status', 'active')
                                                                ->whereHas('purok', function($query) use ($brgyId) {
                                                                    $query->where('brgy_id', $brgyId)
                                                                        ->where('status', 'active');
                                                                });
                                                    });
                                            });
                                })
                                ->whereHas('program', function($query) {
                                    $query->where('category', 'philpen_tcl')
                                            ->where('status', 'active');
                                });
                        })
                        ->where('status', 'pending')
                        ->count();

        return response()->json([
            'status' => 'success',
            'pending_consultations_count' => $pendingCount
        ]);
    }

}
