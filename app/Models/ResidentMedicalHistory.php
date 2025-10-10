<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidentMedicalHistory extends Model
{
    // Explicit table name since it's not the plural of the model
    protected $table = 'resident_medical_history';

    // Mass-assignable fields
    protected $fillable = [
        'resident_id',
        'hypertension',
        'heart_diseases',
        'copd',
        'surgical_history',
        'allergies',
        'diabetes',
        'cancer',
        'asthma',
        'kidney_disorders',
        'vision_problems',
        'thyroid_disorders',
        'mental_neuro_substance_disorders',
    ];

    // Cast booleans
    protected $casts = [
        'hypertension'                     => 'boolean',
        'heart_diseases'                   => 'boolean',
        'copd'                             => 'boolean',
        'surgical_history'                 => 'boolean',
        'allergies'                        => 'boolean',
        'diabetes'                         => 'boolean',
        'cancer'                           => 'boolean',
        'asthma'                           => 'boolean',
        'kidney_disorders'                 => 'boolean',
        'vision_problems'                  => 'boolean',
        'thyroid_disorders'                => 'boolean',
        'mental_neuro_substance_disorders' => 'boolean',
    ];

    // Relationship: medical history belongs to one resident
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
