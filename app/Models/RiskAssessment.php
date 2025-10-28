<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessment extends Model
{
    use HasFactory;

    protected $table = 'risk_assessment';

    protected $fillable = [
        'consultation_id',
        'polyphagia',
        'polydipsia',
        'polyuria',
        'breathlessness',
        'chronic_cough',
        'sputum_production',
        'wheezing',
        'fbs_result',
        'rbs_result',
        'total_cholesterol',
        'hdl',
        'ldl',
        'vldl',
        'triglyceride',
        'protein',
        'ketones',
        'blood_sugar_date_taken',
        'lipid_profile_date_taken',
        'urinalysis_date_taken',
    ];

    /**
     * A risk assessment belongs to a resident.
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }
}
