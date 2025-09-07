<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Schedules;
use App\Models\Midwife;
use App\Models\BHW;
use App\Models\ScheduleAssignments;

class Schedules extends Model
{
    protected $fillable = [
        'brgy_id',
        'health_program_id',
        'added_by',
        'date',
        'time',
        'activity',
        'venue',
        'status', // since you added it
    ];

    // Optional: if your table name is not the default plural 'schedules'
    // protected $table = 'schedules';
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }

    // Link to Health Program
    public function healthProgram()
    {
        return $this->belongsTo(HealthProgram::class, 'health_program_id');
    }

    // Link to User who added
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    // Link to assigned BHWs (many-to-many pivot)
    public function assignedBHWs()
    {
        return $this->belongsToMany(BHW::class, 'schedule_assignments', 'schedule_id', 'personnel_id');
    }

}
