<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NcdRiskFactor extends Model
{
    use HasFactory;

    protected $table = 'ncd_risk_factors';

    protected $fillable = [
        'resident_id',
        'tobacco_use',
        'alcohol_intake',
        'caffeine_intake',
        'high_fat_high_salt_food_intake',
        'street_foods_intake',
        'high_sugar_foods_intake',
        'number_of_drinks_last_year',
        'hours_of_activity_weekly',
        'weight',
        'height',
        'waist_circumference',
        'systolic_pressure',
        'diastolic_pressure',
    ];

    /**
     * A risk factor record belongs to a resident.
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
