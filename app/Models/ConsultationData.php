<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationData extends Model
{
    use HasFactory;

    protected $table = 'consultation_data';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'consultation_id',
        'father_name',
        'mother_name',
        'is_philhealth',
        'chief_complaint',
        'treatment',
        'birthweight',
        'weight',
        'height',
        'bp_systolic',
        'bp_diastolic',
        'rr',
        'temperature',
        'pr',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_philhealth' => 'boolean',
        'birthweight' => 'integer',
        'weight' => 'float',
        'height' => 'float',
        'bp_systolic' => 'integer',
        'bp_diastolic' => 'integer',
        'rr' => 'integer',
        'temperature' => 'float',
        'pr' => 'integer',
    ];

    /**
     * Relationship: ConsultationData belongs to a Consultation.
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }
}
