<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\Consultation;
use App\Models\ConsultationData;
use App\Models\EnrolledResident;
use App\Models\MedicineDistribution;
use App\Models\MedicineInventory;
use App\Models\BasicHealthRecord;
use App\Models\Resident;
use App\Models\HealthSigns;
use App\Models\ResidentMedicalHistory;
use App\Models\ResidentFamilyHistory;
use App\Models\RiskAssessment;
use App\Models\NcdRiskFactor;
use App\Models\PhilpenManagement;
use App\Models\ActivityLog;
use Carbon\Carbon;


class ConsultationController extends Controller
{

    public function updateConsultation(Request $request)
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

        // 1. Find consultation with relationships
        $consultation = Consultation::with(['enrolledResident.resident', 'enrolledResident.program'])
            ->findOrFail($request->input('consultation_id'));
            
        if (!$consultation->enrolled_resident_id) {
            return response()->json(['error' => 'Consultation not linked to enrolled resident'], 400);
        }

        Log::info($consultation);

        $consultation->update([
            'status' => 'completed',
            'updated_by' => auth()->id(),
        ]);

        // 2. Save or update consultation data
        ConsultationData::updateOrCreate(
            ['consultation_id' => $consultation->id],
            [
                'chief_complaint' => $request->input('chief_complaint'),
                'treatment' => $request->input('treatment'),
                'weight' => $request->input('consultation_data.weight'),
                'height' => $request->input('consultation_data.height'),
                'bp_systolic' => $request->input('consultation_data.bp_systolic'),
                'bp_diastolic' => $request->input('consultation_data.bp_diastolic'),
                'rr' => $request->input('consultation_data.respiratory_rate'),
                'temperature' => $request->input('consultation_data.temperature'),
                'pr' => $request->input('consultation_data.pulse_rate'),
            ]
        );

        // 3. Handle medicine distributions
        $medicineDistributions = $request->input('medicine_distributions', []);
        
        if (!empty($medicineDistributions) && is_array($medicineDistributions)) {
            foreach ($medicineDistributions as $distribution) {
                $medicineId = $distribution['medicine_id'] ?? null;
                $quantity = $distribution['quantity'] ?? 0;

                if (!$medicineId || $quantity <= 0) {
                    continue;
                }

                $remainingQty = $quantity;

                MedicineDistribution::create([
                    'medicine_id' => $medicineId,
                    'distributed_by' => auth()->id(),
                    'consultation_id' => $consultation->id,
                    'quantity' => $quantity,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $batches = MedicineInventory::where('medicine_id', $medicineId)
                    ->whereDate('expiry_date', '>', now()->addMonths(2))
                    ->orderBy('expiry_date', 'asc')
                    ->get();

                foreach ($batches as $batch) {
                    if ($remainingQty <= 0) break;

                    if ($batch->stock >= $remainingQty) {
                        $batch->stock -= $remainingQty;
                        $batch->save();
                        $remainingQty = 0;
                    } else {
                        $remainingQty -= $batch->stock;
                        $batch->stock = 0;
                        $batch->save();
                    }
                }
            }
        }

        // 4. Check enrolled resident status
        $enrolledResident = $consultation->enrolledResident;
        $allCompleted = Consultation::where('enrolled_resident_id', $enrolledResident->id)
            ->where('status', '!=', 'completed')
            ->count() === 0;

        if ($allCompleted) {
            $enrolledResident->update(['status' => 'completed']);
        }

        // 5. Update Basic Health Record (only non-null fields)
        $basicHR = BasicHealthRecord::firstOrCreate([
            'resident_id' => $consultation->resident_id,
        ]);

        $updateData = array_filter([
            'weight' => $request->input('consultation_data.weight'),
            'height' => $request->input('consultation_data.height'),
            'systolic_pressure' => $request->input('consultation_data.bp_systolic'),
            'diastolic_pressure' => $request->input('consultation_data.bp_diastolic'),
        ], fn($value) => !is_null($value));

        if (!empty($updateData)) {
            $basicHR->update($updateData);
        }

        // 6. Create Activity Log
        $resident = $enrolledResident->resident;
        $program = $enrolledResident->program;
        $residentName = trim($resident->firstName . ' ' . ($resident->middleName ? $resident->middleName . ' ' : '') . $resident->lastName . ($resident->suffix ? ' ' . $resident->suffix : ''));
        $programName = $program->name;
        $consultationTitle = $consultation->consultation_title ?? 'consultation';
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'module_id' => 5, // Replace with your correct module ID for health programs/consultations
            'activity' => "Updated {$consultationTitle} consultation for resident {$residentName} in {$programName} health program.",
        ]);

        // 7. Return success response
        return response()->json([
            'success' => true,
            'message' => 'Consultation successfully updated',
            'consultation_id' => $consultation->id,
            'data' => $request->all(),
        ], 200);
    }
}
