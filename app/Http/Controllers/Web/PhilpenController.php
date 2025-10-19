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
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            foreach ($enrolledResidents as $enrolledResident) {
                $newConsultations[] = [
                    'consultation_title' => 'Scheduled Return',
                    'enrolled_resident_id' => $enrolledResident->id,
                    'resident_id' => $enrolledResident->resident_id,
                    'consultation_date' => $validated['consultation_date'],
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Bulk insert new consultations
            if (!empty($newConsultations)) {
                Consultation::insert($newConsultations);
            }

            DB::commit();

            \Log::info('Scheduled consultation date:', [
                'consultation_date' => $validated['consultation_date'],
                'updated_consultations' => $updatedCount,
                'new_consultations' => count($newConsultations)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Consultation date logged successfully.',
                'data' => [
                    'consultation_date' => $validated['consultation_date'],
                    'previous_consultations_completed' => $updatedCount,
                    'new_consultations_created' => count($newConsultations)
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('Failed to create consultations:', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create consultations.',
                'error' => $e->getMessage()
            ], 500);
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
