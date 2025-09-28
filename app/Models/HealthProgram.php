<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProgram extends Model
{
    use HasFactory;

    // Explicitly map to the table (optional since Laravel infers it)
    protected $table = 'health_programs';

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'status',
        'age_min',
        'age_max',
        'category', 
        'total_fields', 
        'schedule_type',
        'program_mode',
    ];

    // Casts (useful if you want `status` as string always)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function enrolledResidents()
    {
        return $this->hasMany(EnrolledResident::class, 'program_id');
    }

    public function programFields()
    {
        return $this->hasMany(ProgramField::class, 'program_id');
    }

}
