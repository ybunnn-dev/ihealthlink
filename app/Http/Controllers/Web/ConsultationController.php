<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Consultation;
use App\Models\ConsultationData;
use App\Models\EnrolledResident;
use App\Models\MedicineDistribution;
use App\Models\MedicineInventory;
use App\Models\BasicHealthRecord;

use Carbon\Carbon;

class ConsultationController extends Controller
{
    public function getConsultation($id)
    {
        $consultation = Consultation::with([
            'consultationData',
            'medicineDistributions.medicine',
            'updatedBy:id,firstName,middleName,lastName,suffix', 
        ])->findOrFail($id);

        // Combine full name for logging or return
        if ($consultation->updatedBy) {
            $updatedBy = $consultation->updatedBy;
            $fullName = trim("{$updatedBy->firstName} {$updatedBy->middleName} {$updatedBy->lastName} {$updatedBy->suffix}");
            $consultation->updatedBy->full_name = preg_replace('/\s+/', ' ', $fullName); // clean extra spaces
        }

        \Log::info('Consultation fetched with relationships:', $consultation->toArray());

        return response()->json($consultation);
    }

    public function store(Request $request)
    {
        $payload = $request->all();

        // 1. Find consultation
        $consultation = Consultation::findOrFail($payload['consultation_id']);
        if (!$consultation->enrolled_resident_id) {
            return response()->json(['error' => 'Consultation not linked to enrolled resident'], 400);
        }

        // 2. Update consultation
        $consultation->update([
            'status' => 'completed',
            'updated_by' => auth()->id(),
        ]);

        // 3. Update or create consultation data
        ConsultationData::updateOrCreate(
            ['consultation_id' => $consultation->id],
            [
                'father_name' => $payload['father_name'],
                'mother_name' => $payload['mother_name'],
                'is_philhealth' => $payload['is_philhealth'],
                'chief_complaint' => $payload['chief_complaint'],
                'treatment' => $payload['treatment'],
                'birthweight' => $payload['birthweight'],
                'weight' => $payload['weight'],
                'height' => $payload['height'],
                'bp_systolic' => $payload['bp_systolic'],
                'bp_diastolic' => $payload['bp_diastolic'],
                'rr' => $payload['rr'],
                'temperature' => $payload['temperature'],
                'pr' => $payload['pr'],
            ]
        );

        // 4. Handle medicine distributions
        foreach ($payload['distributed_medicines'] as $medicine) {
            $remainingQty = $medicine['quantity'];

            // Create a distribution record
            MedicineDistribution::create([
                'medicine_id' => $medicine['id'],
                'distributed_by' => auth()->id(),
                'consultation_id' => $consultation->id,
                'quantity' => $medicine['quantity'],
            ]);

            // Reduce inventory using Eloquent
            $batches = MedicineInventory::where('medicine_id', $medicine['id'])
                ->whereDate('expiry_date', '>', now()->addMonth())
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

        // 5. Check enrolled resident status
        $enrolledResident = EnrolledResident::find($consultation->enrolled_resident_id);
        $allCompleted = Consultation::where('enrolled_resident_id', $enrolledResident->id)
            ->where('status', '!=', 'completed')
            ->count() === 0;

        if ($allCompleted) {
            $enrolledResident->update(['status' => 'completed']);
        }

        $basicHR = BasicHealthRecord::firstOrCreate([
            'resident_id' => $consultation->resident_id,
        ]);

       // Prepare update data — only include non-null values
        $updateData = array_filter([
            'weight' => $payload['weight'] ?? null,
            'height' => $payload['height'] ?? null,
            'systolic_pressure' => $payload['bp_systolic'] ?? null,
            'diastolic_pressure' => $payload['bp_diastolic'] ?? null,
            'is_pregnant' => $payload['is_pregnant'] ?? null,
            'is_lactating' => $payload['is_lactating'] ?? null,
        ], fn($value) => !is_null($value));

        // Update only if there’s something to update
        if (!empty($updateData)) {
            $basicHR->update($updateData);
        }

        return response()->json(['message' => 'Consultation updated successfully']);
    }
}
