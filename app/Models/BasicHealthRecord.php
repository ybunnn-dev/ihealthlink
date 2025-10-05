<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicHealthRecord extends Model
{
    use HasFactory;

    protected $table = 'basic_health_records';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'resident_id',
        'weight',
        'height',
        'status',
        'health_records',
        'waist_circumference',
        'systolic_pressure',
        'diastolic_pressure',
        'is_pregnant',
        'is_lactating',
        'weight_grams',
    ];

    protected $casts = [
        'is_pregnant' => 'boolean',
        'is_lactating' => 'boolean',
        'weight' => 'float',
        'height' => 'float',
        'weight_grams' => 'integer',
        'systolic_pressure' => 'integer',
        'diastolic_pressure' => 'integer',
    ];

    /**
     * Relationship: A basic health record belongs to a resident.
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
