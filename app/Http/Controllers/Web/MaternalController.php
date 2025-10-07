<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BasicMaternalRecord;
use App\Models\EnrolledResident;
use App\Models\Consultation;
use App\Models\BasicHealthRecord;

class MaternalController extends Controller
{
    public function enroll(Request $request)
    {
        $validated = $request->validate([
            'health_program_id' => 'required|integer|exists:health_programs,id',
            'resident_id' => 'required|integer|exists:residents,id',
            'last_menstrual_period' => 'required|date',
            'expected_date_of_confinement' => 'required|date|after:last_menstrual_period',
            'gravida' => 'required|integer|min:0',
            'para' => 'required|integer|min:0|lte:gravida',
        ]);

        // Step 1: Enroll the resident into the program
        $enrollment = EnrolledResident::create([
            'resident_id' => $validated['resident_id'],
            'program_id' => $validated['health_program_id'],
            'enrolled_by' => auth()->id(),
            'status' => 'active',
        ]);

        // Step 2: Create basic maternal record linked to enrolled resident
        $record = BasicMaternalRecord::create([
            'enrolled_resident_id' => $enrollment->id,
            'last_menstrual_period' => $validated['last_menstrual_period'],
            'expected_date_of_confinement' => $validated['expected_date_of_confinement'],
            'gravida' => $validated['gravida'],
            'para' => $validated['para'],
        ]);

        $this->createConsultationSchedules(
            $validated['resident_id'],
            $enrollment->id,
            $validated['last_menstrual_period']
        );

        $basicHealthRecord = BasicHealthRecord::where('resident_id', $validated['resident_id'])->first();

         if ($basicHealthRecord) {
            $basicHealthRecord->update(['is_pregnant' => true]);
        }

        return response()->json([
            'message' => 'Maternal record enrolled successfully',
            'enrollment' => $enrollment,
            'maternal_record' => $record,
        ]);
    }
    protected function createConsultationSchedules($residentId, $enrollId, $lmp)
    {
        $lmp = \Carbon\Carbon::parse($lmp);

        $consultations = [
            // Trimester schedules
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $lmp->copy()->addWeeks(12),
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Trimester 1',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $lmp->copy()->addWeeks(24),
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Trimester 2',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $lmp->copy()->addWeeks(32),
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Trimester 3 (1)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => $lmp->copy()->addWeeks(36),
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Trimester 3 (2)',
                'remarks' => null,
                'updated_by' => null,
            ],

            // Postpartum schedules (consultation_date = null)
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (within 24h)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (within 7 days)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (1 month)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (2 months)',
                'remarks' => null,
                'updated_by' => null,
            ],
            [
                'resident_id' => $residentId,
                'enrolled_resident_id' => $enrollId,
                'consultation_date' => null,
                'status' => 'pending',
                'schedule_extension_days' => 0,
                'consultation_title' => 'Postpartum (3 months)',
                'remarks' => null,
                'updated_by' => null,
            ],
        ];
        Consultation::insert($consultations);
    }
}
