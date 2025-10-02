<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealthProgram;
use App\Models\ProgramSchedule;

class HealthProgramController extends Controller
{
    /**
     * Provide all health programs (active + inactive).
     */
    public function provideData()
    {
        $programs = HealthProgram::all();

        return response()->json([
            'success' => true,
            'data' => $programs
        ]);
    }
    public function index(){
        $programs = HealthProgram::withCount('enrolledResidents')
        ->paginate(10);

        return view('mho.health-program-list', [
            'healthPrograms' => $programs
        ]);
    }

    public function show(HealthProgram $healthProgram)
    {
        
        $healthProgram = HealthProgram::withCount('enrolledResidents')
            ->with('programFields') 
            ->findOrFail($healthProgram->id);

        return view('mho.spec-health-program', [
            'healthProgram' => $healthProgram
        ]);
    }
    public function store(Request $request)
    {
        \Log::info('Health Program Payload:', $request->all());

        // Step 1: Create Health Program
        $program = HealthProgram::create([
            'name'          => $request->input('program_name'),   // from frontend
            'age_min'       => $request->input('min_age'),
            'age_max'       => $request->input('max_age'),
            'category'      => $request->input('program_type'),
            'program_mode'  => $request->input('program_mode'),
            'schedule_type' => $request->input('schedType', null),
            'total_fields'  => $request->input('field_num', null),
            'status'        => 'active',
        ]);

        switch ($request->input('program_mode')) {
            case 'fixed':
                $fieldNum = (int) $request->input('field_num');
                $interval = (int) $request->input('interval');

                for ($i = 1; $i <= $fieldNum; $i++) {
                    ProgramField::create([
                        'title'        => "Field $i",
                        'program_id'   => $program->id,
                        'interval_days'=> $interval,
                        'order'        => $i,
                        'status'       => 'active',
                    ]);
                }
                break;

            case 'custom':
                $schedules = $request->input('fixedSched', []);
                foreach ($schedules as $sched) {
                    ProgramField::create([
                        'title'        => $sched['schedTitle'],
                        'program_id'   => $program->id,
                        'interval_days'=> (int) $sched['intervalDays'],
                        'order'        => (int) $sched['position'],
                        'status'       => 'active',
                    ]);
                }
                break;

            case 'continuous':
                ProgramField::create([
                    'title'        => "Continuous Field",
                    'program_id'   => $program->id,
                    'interval_days'=> (int) $request->input('interval', 0),
                    'order'        => 1,
                    'status'       => 'active',
                ]);
                break;
        }

        return response()->json([
            'message' => 'Health Program created successfully!',
            'response' => 'success',
            'data'    => $program->load('programFields'),
            'id' => $program->id
        ]);
    }
}
