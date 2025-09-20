<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthSigns extends Model
{
    // Explicitly set table name since it's not the plural of the model
    protected $table = 'resident_health_signs';

    // Fillable fields (mass-assignable)
    protected $fillable = [
        'resident_id',
        'chest_pain',
        'difficulty_in_breathing',
        'loss_of_consciousness',
        'numbness_of_arm',
        'act_of_self_harm_or_suicide',
        'agitated_or_aggressive_behavior',
        'severe_injuries',
        'slurred_speech',
        'facial_asymmetry',
        'chest_retractions',
        'seizure_or_convulsion',
        'disoriented_as_to_time_place_or_person',
        'eye_injury',
    ];

    // Cast tinyint(1) to boolean automatically
    protected $casts = [
        'chest_pain'                         => 'boolean',
        'difficulty_in_breathing'            => 'boolean',
        'loss_of_consciousness'              => 'boolean',
        'numbness_of_arm'                    => 'boolean',
        'act_of_self_harm_or_suicide'        => 'boolean',
        'agitated_or_aggressive_behavior'    => 'boolean',
        'severe_injuries'                    => 'boolean',
        'slurred_speech'                     => 'boolean',
        'facial_asymmetry'                   => 'boolean',
        'chest_retractions'                  => 'boolean',
        'seizure_or_convulsion'              => 'boolean',
        'disoriented_as_to_time_place_or_person' => 'boolean',
        'eye_injury'                         => 'boolean',
    ];

    // Relationship: one set of health signs belongs to a resident
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
