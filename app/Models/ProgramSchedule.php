<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSchedule extends Model
{
    use HasFactory;

    protected $table = 'program_schedules';

    protected $fillable = [
        'title',
        'program_id',
        'interval_days',
        'order',
        'status',
        'extension_days',
    ];

    /**
     * Relationship: A ProgramField belongs to a HealthProgram
     */
    public function healthProgram()
    {
        return $this->belongsTo(HealthProgram::class, 'program_id');
    }

}
