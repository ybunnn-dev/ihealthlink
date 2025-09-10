<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleAssignments extends Model
{
    protected $fillable = [
        'schedule_id',
        'personnel_id',
    ];

    // Link back to schedule
    public function schedule()
    {
        return $this->belongsTo(Schedules::class, 'schedule_id');
    }

    // Link to BHW (filtered personnel)
    public function bhw()
    {
        return $this->belongsTo(BHW::class, 'personnel_id');
    }
}
