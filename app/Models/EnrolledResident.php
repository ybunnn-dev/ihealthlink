<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledResident extends Model
{
    use HasFactory;

    protected $table = 'enrolled_residents';

    protected $fillable = [
        'resident_id',
        'program_id',
        'enrolled_by',
        'updated_by',
        'status',
    ];

    /**
     * Relationships
     */

    // Link to resident
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    // Link to health program
    public function program()
    {
        return $this->belongsTo(HealthProgram::class);
    }

    // The user who enrolled the resident
    public function enrolledBy()
    {
        return $this->belongsTo(User::class, 'enrolled_by');
    }

    // The user who last updated the enrollment
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'resident_id', 'resident_id');
    }
}
