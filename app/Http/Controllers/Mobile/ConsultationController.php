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
use Illuminate\Support\Facades\DB;



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

    public function createConsultation(Request $request)
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

        $validated = $request->validate([
            'resident_id' => 'required|integer',
            'consultation_date' => 'required|date',
            'status' => 'required|string',
            'chief_complaint' => 'nullable|string',
            'treatment' => 'nullable|string',
            'consultation_data' => 'required|array',
            'consultation_data.weight' => 'nullable|numeric',
            'consultation_data.height' => 'nullable|numeric',
            'consultation_data.bp_systolic' => 'nullable|integer',
            'consultation_data.bp_diastolic' => 'nullable|integer',
            'consultation_data.temperature' => 'nullable|numeric',
            'consultation_data.pulse_rate' => 'nullable|integer',
            'consultation_data.respiratory_rate' => 'nullable|integer',
            'consultation_data.is_pregnant' => 'nullable|boolean',
            'consultation_data.is_lactating' => 'nullable|boolean',
            'medicine_distributions' => 'nullable|array', // Changed to nullable
            'medicine_distributions.*.medicine_id' => 'required|integer',
            'medicine_distributions.*.quantity' => 'required|integer|min:1',
        ]);

        // Get resident and build full name
        $resident = Resident::findOrFail($validated['resident_id']);
        
        $residentName = trim(
            $resident->first_name . ' ' . 
            ($resident->middle_name ? $resident->middle_name . ' ' : '') . 
            $resident->last_name . 
            ($resident->suffix ? ' ' . $resident->suffix : '')
        );
        
        Log::info("Creating consultation for: {$residentName}");
        
        DB::beginTransaction();
        
        try {
            $consultationData = $validated['consultation_data'];
            
            // 1. Create the consultation record
            $consultation = Consultation::create([
                'resident_id' => $validated['resident_id'],
                'consultation_date' => $validated['consultation_date'],
                'status' => $validated['status'],
                'is_pregnant' => $consultationData['is_pregnant'] ?? false,
                'is_lactating' => $consultationData['is_lactating'] ?? false,
                'updated_by' => auth()->id() ?? null,
            ]);
            
            Log::info('✅ Consultation created with ID: ' . $consultation->id);

            // 2. Create consultation data
            ConsultationData::create([
                'consultation_id' => $consultation->id,
                'chief_complaint' => $validated['chief_complaint'],
                'treatment' => $validated['treatment'],
                'weight' => $consultationData['weight'],
                'height' => $consultationData['height'],
                'bp_systolic' => $consultationData['bp_systolic'],
                'bp_diastolic' => $consultationData['bp_diastolic'],
                'temperature' => $consultationData['temperature'],
                'pr' => $consultationData['pulse_rate'],
                'rr' => $consultationData['respiratory_rate'],
            ]);
            
            Log::info('✅ Consultation data created');

            // 3. Handle medicine distributions and inventory reduction (ONLY IF PROVIDED)
            $distributions = $validated['medicine_distributions'] ?? [];
            
            if (!empty($distributions)) {
                Log::info('--- 💊 Processing ' . count($distributions) . ' medicine distribution(s) ---');
                
                foreach ($distributions as $index => $medicine) {
                    $remainingQty = $medicine['quantity'];
                    
                    MedicineDistribution::create([
                        'consultation_id' => $consultation->id,
                        'medicine_id' => $medicine['medicine_id'],
                        'quantity' => $medicine['quantity'],
                        'distributed_by' => auth()->id() ?? null,
                        'distributed_at' => now(),
                    ]);
                    
                    Log::info(($index + 1) . '. Medicine distributed: ID ' . $medicine['medicine_id'] . ', Qty: ' . $medicine['quantity']);
                    
                    $batches = MedicineInventory::where('medicine_id', $medicine['medicine_id'])
                        ->whereDate('expiry_date', '>', now()->addMonth())
                        ->where('stock', '>', 0)
                        ->orderBy('expiry_date', 'asc')
                        ->get();
                    
                    if ($batches->isEmpty()) {
                        throw new \Exception(
                            "Insufficient inventory for Medicine ID {$medicine['medicine_id']}. " .
                            "No batches available or all batches expire within 1 month."
                        );
                    }
                    
                    foreach ($batches as $batch) {
                        if ($remainingQty <= 0) break;
                        
                        if ($batch->stock >= $remainingQty) {
                            $batch->stock -= $remainingQty;
                            $batch->save();
                            
                            Log::info("   └─ Reduced batch ID {$batch->id} by {$remainingQty} (remaining: {$batch->stock})");
                            $remainingQty = 0;
                        } else {
                            $usedQty = $batch->stock;
                            $remainingQty -= $batch->stock;
                            $batch->stock = 0;
                            $batch->save();
                            
                            Log::info("   └─ Depleted batch ID {$batch->id} (used: {$usedQty}, still need: {$remainingQty})");
                        }
                    }
                    
                    if ($remainingQty > 0) {
                        throw new \Exception(
                            "Insufficient inventory for Medicine ID {$medicine['medicine_id']}. " .
                            "Needed {$medicine['quantity']}, but only had " . ($medicine['quantity'] - $remainingQty) . " available."
                        );
                    }
                }
                
                Log::info('✅ Medicine distributions completed and inventory reduced');
            } else {
                Log::info('ℹ️ No medicine distributions to process');
            }

            // 4. Update or create basic health record (preserve existing values, only update non-null)
            $healthRecord = BasicHealthRecord::firstOrNew(['resident_id' => $validated['resident_id']]);

            // Only update fields that have non-null values
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

            // Always update pregnant/lactating status (even if false)
            $healthRecord->is_pregnant = $consultationData['is_pregnant'] ?? false;
            $healthRecord->is_lactating = $consultationData['is_lactating'] ?? false;

            $healthRecord->save();
            
            Log::info('✅ Basic health record updated');

            DB::commit();
            
            // Activity log
            ActivityLog::create([
                'user_id' => auth()->id(),
                'module_id' => 7,
                'activity' => "Created consultation for {$residentName}" . 
                            (!empty($distributions) ? " with " . count($distributions) . " medicine distribution(s)" : ""),
            ]);

            return response()->json([
                'message' => 'Consultation created successfully',
                'consultation_id' => $consultation->id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('--- ❌ Error creating consultation ---');
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'message' => 'Failed to create consultation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
