<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HealthProgram;
use App\Models\ProgramField;
use App\Models\EnrolledResident;

class BarangayHealthProgramController extends Controller
{
    public function index(HealthProgram $healthProgram = null)
    {
        if (!$healthProgram) {
            $healthProgram = HealthProgram::latest()->first();
        }

        // Load enrolled residents + their consultations
        $enrolledResidents = EnrolledResident::with(['resident.consultations' => function ($q) use ($healthProgram) {
            $q->where('program_id', $healthProgram->id);
        }])
        ->where('program_id', $healthProgram->id)
        ->get();

        $totalEnrolled = $enrolledResidents->count();

        // Completed enrolled residents
        $completed = $enrolledResidents->where('status', 'completed')->count();

        $overdue = $enrolledResidents->filter(function ($enrollment) {
            return $enrollment->resident->consultations->contains(function ($consultation) {
                return $consultation->status === 'pending'
                    && $consultation->consultation_date < now();
            });
        })->count();

        return view('midwife.health-program', compact(
            'healthProgram',
            'enrolledResidents',
            'totalEnrolled',
            'completed',
            'overdue'
        ));
    }

}
