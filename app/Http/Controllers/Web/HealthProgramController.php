<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealthProgram;
use App\Models\ProgramSchedule;
use Illuminate\Pagination\Paginator; 

class HealthProgramController extends Controller
{
    public function provideData()
    {
        $programs = HealthProgram::all();

        return response()->json([
            'success' => true,
            'data' => $programs
        ]);
    }

    public function index(Request $request)
    {
        $query = HealthProgram::withCount('enrolledResidents');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        
        // Sort functionality
        if ($request->has('sort_by') && $request->sort_by != 'all') {
            $sortField = $request->sort_by;
            $sortOrder = $request->get('sort_order', 'asc');
            
            if ($sortField == 'residents_count') {
                $query->orderBy('enrolled_residents_count', $sortOrder);
            } else {
                $query->orderBy($sortField, $sortOrder);
            }
        }
        
        // Date filter
        if ($request->has('date_filter') && $request->date_filter != 'all') {
            switch ($request->date_filter) {
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }
        
        $programs = $query->paginate(8);
        
        // Check for AJAX with multiple detection methods
        $isAjax = $request->ajax() || 
                $request->header('X-Requested-With') === 'XMLHttpRequest' || 
                $request->wantsJson();
        
        if ($isAjax) {
            return response()->json([
                'html' => view('components.health-program.table', [
                    'healthPrograms' => $programs
                ])->render(),
                'pagination' => $programs->links()->render()
            ]);
        }
        
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
                $extension = (int) $request->input('extension_days');
                for ($i = 1; $i <= $fieldNum; $i++) {
                    ProgramSchedule::create([
                        'title'        => "Field $i",
                        'program_id'   => $program->id,
                        'interval_days'=> $interval,
                        'order'        => $i,
                        'extension_days' => $extension,
                        'status'       => 'active',
                    ]);
                }
                break;

            case 'custom':
                $schedules = $request->input('fixedSched', []);
                foreach ($schedules as $sched) {
                    ProgramSchedule::create([
                        'title'        => $sched['schedTitle'],
                        'program_id'   => $program->id,
                        'interval_days'=> (int) $sched['intervalDays'],
                        'order'        => (int) $sched['position'],
                        'extension_days' => (int) $sched['extension_days'],
                        'status'       => 'active',
                    ]);
                }
                break;

            case 'continuous':
                $extension = (int) $request->input('extension_days');
                ProgramSchedule::create([
                    'title'        => "Scheduled Return",
                    'program_id'   => $program->id,
                    'interval_days'=> (int) $request->input('interval', 0),
                    'order'        => 1,
                    'status'       => 'active',
                    'extension_days' => $extension,
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
