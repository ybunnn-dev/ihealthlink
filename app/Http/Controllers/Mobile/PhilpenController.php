<?php

namespace App\Http\Controllers\Mobile;

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
use App\Services\Notifications\FireBase;
use App\Models\HealthSigns;
use App\Models\ResidentFamilyHistory;
use App\Models\ResidentMedicalHistory;
use App\Models\NcdRiskFactor;
use App\Models\RiskAssessment;
use App\Models\PhilpenManagement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PhilpenController extends Controller
{
    public function getLatestPhilpenData(Request $request)
    {
        $validated = $request->validate([
            'purok_ids' => 'required|array',
            'purok_ids.*' => 'integer|exists:puroks,id'
        ]);

        $user = Auth::user();
        $personnel = $user->midwife ?? $user->bhwWeb ?? $user->bhw;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $brgyId = $personnel->brgy_id;
        $purokIds = $validated['purok_ids'];

        // Get enrolled residents with their latest pending consultation
        $enrolledResidents = EnrolledResident::where('status', 'active')
            ->whereHas('resident', function($query) use ($brgyId, $purokIds) {
                $query->where('status', 'active')
                    ->whereHas('family', function($query) use ($brgyId, $purokIds) {
                        $query->where('status', 'active')
                            ->whereHas('household', function($query) use ($brgyId, $purokIds) {
                                $query->where('status', 'active')
                                    ->whereHas('purok', function($query) use ($brgyId, $purokIds) {
                                        $query->where('brgy_id', $brgyId)
                                            ->where('status', 'active')
                                            ->whereIn('id', $purokIds);
                                    });
                            });
                    });
            })
            ->whereHas('program', function($query) {
                $query->where('category', 'philpen_tcl')
                    ->where('status', 'active');
            })
            ->with([
                'resident' => function($query) {
                    $query->select('id', 'firstName', 'middleName', 'lastName', 'suffix', 'birthdate', 'sex', 'family_id');
                },
                'resident.family' => function($query) {
                    $query->select('id', 'household_id');
                },
                'resident.family.household' => function($query) {
                    $query->select('id', 'purok_id');
                },
                'resident.family.household.purok:id',
                'latestPendingConsultation' => function($query) {
                    // Eager load all PhilPEN records for the consultation
                    $query->with([
                        'healthSigns',
                        'familyHistory',
                        'medicalHistory',
                        'ncdRiskFactor',
                        'riskAssessment',
                        'philpenManagement'
                    ]);
                }
            ])
            ->get();

        // Filter out enrolled residents without pending consultations and transform data
        $transformedData = $enrolledResidents
            ->filter(function($enrolledResident) {
                return $enrolledResident->latestPendingConsultation !== null;
            })
            ->map(function($enrolledResident) {
                $resident = $enrolledResident->resident;
                $consultation = $enrolledResident->latestPendingConsultation;
                
                // Build full name
                $fullName = $resident->firstName;
                if ($resident->middleName) {
                    $fullName .= ' ' . $resident->middleName;
                }
                $fullName .= ' ' . $resident->lastName;
                if ($resident->suffix) {
                    $fullName .= ' ' . $resident->suffix;
                }
                
                // Calculate age
                $age = Carbon::parse($resident->birthdate)->age;
                
                // Get purok ID from nested relationship
                $purokId = $resident->family->household->purok->id;
                
                return [
                    'enrolled_resident_id' => $enrolledResident->id,
                    'purok_id' => $purokId,
                    'resident' => [
                        'id' => $resident->id,
                        'fullName' => $fullName,
                        'age' => $age,
                        'sex' => $resident->sex
                    ],
                    'consultation' => [
                        'id' => $consultation->id,
                        'uuid' => $consultation->uuid,
                        'resident_id' => $consultation->resident_id,
                        'consultation_title' => $consultation->consultation_title,
                        'consultation_date' => $consultation->consultation_date,
                        'status' => $consultation->status,
                        'created_at' => $consultation->created_at,
                        'updated_at' => $consultation->updated_at,
                        
                        // PhilPEN assessment data (all empty initially)
                        'health_signs' => $consultation->healthSigns,
                        'family_history' => $consultation->familyHistory,
                        'medical_history' => $consultation->medicalHistory,
                        'ncd_risk_factor' => $consultation->ncdRiskFactor,
                        'risk_assessment' => $consultation->riskAssessment,
                        'philpen_management' => $consultation->philpenManagement,
                    ]
                ];
            })
            ->values();

        return response()->json([
            'status' => 'success',
            'count' => $transformedData->count(),
            'data' => $transformedData
        ]);
    }
}
