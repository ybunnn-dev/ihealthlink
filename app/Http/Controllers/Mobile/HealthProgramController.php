<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Consultation;
use App\Models\ProgramSchedule;
use App\Models\HealthProgram;
use App\Models\EnrolledResident;
use App\Models\BasicHealthRecord;

class HealthProgramController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $barangayId = $personnel->brgy_id;

        $query = HealthProgram::withCount(['enrolledResidents' => function ($q) use ($barangayId) {
            $q->whereHas('resident.family.household.purok', function ($sub) use ($barangayId) {
                $sub->where('brgy_id', $barangayId);
            });
        }]);

        // Search by program name (optional)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by category (optional)
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category', $category);
        }

        $programs = $query->paginate(10);

        // No need to wrap in response()->json(), paginate does this for you.
        return $programs;
    }

    public function specHP(HealthProgram $healthProgram)
    {
        $user = Auth::user();

        $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;

        if (!$personnel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated personnel found for this user.'
            ], 404);
        }

        $barangayId = $personnel->brgy_id; 

        if (!$healthProgram) {
            $healthProgram = HealthProgram::latest()->first();
        }

        // Get enrolled residents for this health program and midwife's barangay
        $enrolledResidents = EnrolledResident::with(['consultations' => function ($q) {
                $q->orderBy('consultation_date'); // 
            }])
            ->where('program_id', $healthProgram->id)
            ->whereHas('resident.family.household.purok', function ($q) use ($barangayId) {
                $q->where('brgy_id', $barangayId);
            })
            ->get();

        // Filter consultations to only those matching the enrolled resident
        $enrolledResidents->each(function ($enrollment) {
            $enrollment->consultations = $enrollment->consultations
                ->where('enrolled_resident_id', $enrollment->id);
        });

        $totalEnrolled = $enrolledResidents->count();

        $completed = $enrolledResidents->where('status', 'completed')->count();

        $overdue = $enrolledResidents->filter(function ($enrollment) {
            return $enrollment->resident->consultations->contains(function ($consultation) {
                return $consultation->status === 'pending'
                    && \Carbon\Carbon::parse($consultation->consultation_date)->isBefore(\Carbon\Carbon::today());
            });
        })->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'healthProgram' => $healthProgram,
                'enrolledResidents' => $enrolledResidents,
                'totalEnrolled' => $totalEnrolled,
                'completed' => $completed,
                'overdue' => $overdue,
            ],
        ]);
    }
}
