<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    // Explicit table name (optional since Laravel infers plural of class name)
    protected $table = 'consultations';

    // Mass assignable attributes
    protected $fillable = [
        'resident_id',
        'program_id',
        'consultation_date',
        'status',
        'med_dis_id',
        'consultation_title',
        'remarks',
        'updated_by',
    ];

    // Casts for attributes
    protected $casts = [
        'consultation_date' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Consultation belongs to a resident
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    // Consultation belongs to a health program
    public function program()
    {
        return $this->belongsTo(HealthProgram::class, 'program_id');
    }

    // Consultation belongs to a medicine/distribution (?) table
    public function medDis()
    {
        return $this->belongsTo(MedDis::class, 'med_dis_id');
    }

    // Consultation updated by a user (e.g., midwife, admin)
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
