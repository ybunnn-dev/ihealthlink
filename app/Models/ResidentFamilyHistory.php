<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidentFamilyHistory extends Model
{
    protected $table = 'resident_family_histories';

    protected $fillable = [
        'resident_id',
        'hypertension',
        'heart_diseases',
        'copd',
        'tuberculosis_last_five_years',
        'stroke',
        'diabetes_mellitus',
        'cancer',
        'asthma',
        'kidney_disorders',
        'premature_coronary_or_vascular_disease',
        'mental_neurological_substance_abuse_disorders',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}
