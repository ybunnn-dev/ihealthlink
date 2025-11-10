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
            ->with(['programFields' => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('order', 'asc');
            }]) 
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
                for ($i = 1; $i <= $fieldNum; $i++) {
                    ProgramSchedule::create([
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
                    ProgramSchedule::create([
                        'title'        => $sched['schedTitle'],
                        'program_id'   => $program->id,
                        'interval_days'=> (int) $sched['intervalDays'],
                        'order'        => (int) $sched['position'],
                        'status'       => 'active',
                    ]);
                }
                break;

            case 'continuous':
                ProgramSchedule::create([
                    'title'        => "Scheduled Return",
                    'program_id'   => $program->id,
                    'interval_days'=> (int) $request->input('interval', 0),
                    'order'        => 1,
                    'status'       => 'active'
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

    public function update(Request $request, HealthProgram $healthProgram)
    {
        \Log::info('hey');
        // Validate input
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'age_min'  => 'required|integer|min:0|max:150',
            'age_max'  => 'required|integer|min:0|max:1000',
            'category' => 'required|string',
        ]);

        \Log::info('heylo');
        // Check that age_max >= age_min
        if ($validated['age_max'] < $validated['age_min']) {
            return response()->json([
                'message' => 'Max age must be greater than or equal to min age.',
                'errors' => ['age_max' => ['Max age must be greater than or equal to min age.']]
            ], 422);
        }

        // Update only the 4 fields
        $healthProgram->update([
            'name'     => $validated['name'],
            'age_min'  => $validated['age_min'],
            'age_max'  => $validated['age_max'],
            'category' => $validated['category'],
        ]);

        \Log::info($healthProgram);

        return response()->json([
            'message' => 'Health Program updated successfully!',
            'response' => 'success',
            'data' => $healthProgram
        ], 200);
    }

    public function addSched(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|integer|exists:health_programs,id',
            'title' => 'required|string',
            'interval' => 'required|string',
            'position' => 'required|string',
        ]);

        \DB::beginTransaction();
        
        try {
            $programId = $validated['program_id'];
            $position = $validated['position'];
            
            // Determine the new order position
            if ($position === 'start') {
                // Insert at the beginning - increment all existing orders
                ProgramSchedule::where('program_id', $programId)
                    ->increment('order');
                
                $newOrder = 1;
                
            } else {
                // Position is an ID - convert to integer
                $positionId = (int) $position;
                
                // Insert after that schedule
                $afterSchedule = ProgramSchedule::where('program_id', $programId)
                    ->where('id', $positionId)
                    ->first();
                
                if (!$afterSchedule) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid position schedule ID.'
                    ], 400);
                }
                
                $insertOrder = $afterSchedule->order + 1;
                
                // Increment all schedules that come after this position
                ProgramSchedule::where('program_id', $programId)
                    ->where('order', '>=', $insertOrder)
                    ->increment('order');
                
                $newOrder = $insertOrder;
            }
            
            // Create the new schedule
            $schedule = ProgramSchedule::create([
                'program_id' => $programId,
                'title' => $validated['title'],
                'interval_days' => $validated['interval'],
                'order' => $newOrder,
                'status' => 'active',
            ]);
            
            \DB::commit();
            
            \Log::info('Schedule created successfully:', [
                'schedule_id' => $schedule->id,
                'order' => $newOrder,
                'position' => $position
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Schedule has been successfully added.',
                'schedule' => $schedule
            ]);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Error creating schedule:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to add schedule. Please try again.'
            ], 500);
        }
    }


    public function updateSched(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|integer|exists:program_schedules,id',
            'program_id' => 'required|integer|exists:health_programs,id',
            'title' => 'required|string',
            'interval' => 'required|string',
            'position' => 'required|string',
        ]);

        \DB::beginTransaction();
        
        try {
            $scheduleId = $validated['schedule_id'];
            $programId = $validated['program_id'];
            $position = $validated['position'];
            
            // Get the schedule being updated
            $schedule = ProgramSchedule::where('id', $scheduleId)
                ->where('program_id', $programId)
                ->first();
            
            if (!$schedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Schedule not found.'
                ], 404);
            }
            
            $oldOrder = $schedule->order;
            $newOrder = null;
            
            // Determine the new order position
            if ($position === 'start') {
                // Moving to the beginning
                $newOrder = 1;
                
            } else {
                // Position is an ID - convert to integer
                $positionId = (int) $position;
                
                // Find the schedule to position after
                $afterSchedule = ProgramSchedule::where('program_id', $programId)
                    ->where('id', $positionId)
                    ->first();
                
                if (!$afterSchedule) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid position schedule ID.'
                    ], 400);
                }
                
                $newOrder = $afterSchedule->order + 1;
            }
            
            // Re-order schedules if position changed
            if ($oldOrder !== $newOrder) {
                if ($newOrder < $oldOrder) {
                    // Moving up (to a lower order number)
                    // Increment all schedules between new and old position
                    ProgramSchedule::where('program_id', $programId)
                        ->where('id', '!=', $scheduleId)
                        ->where('order', '>=', $newOrder)
                        ->where('order', '<', $oldOrder)
                        ->increment('order');
                        
                } else {
                    // Moving down (to a higher order number)
                    // Decrement all schedules between old and new position
                    ProgramSchedule::where('program_id', $programId)
                        ->where('id', '!=', $scheduleId)
                        ->where('order', '>', $oldOrder)
                        ->where('order', '<=', $newOrder)
                        ->decrement('order');
                        
                    // Adjust newOrder since we decremented
                    $newOrder = $newOrder;
                }
            }
            
            // Update the schedule
            $schedule->update([
                'title' => $validated['title'],
                'interval_days' => $validated['interval'],
                'order' => $newOrder,
            ]);
            
            \DB::commit();
            
            \Log::info('Schedule updated successfully:', [
                'schedule_id' => $schedule->id,
                'old_order' => $oldOrder,
                'new_order' => $newOrder,
                'position' => $position
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Schedule has been successfully updated.',
                'schedule' => $schedule
            ]);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Error updating schedule:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update schedule. Please try again.'
            ], 500);
        }
    }

}
