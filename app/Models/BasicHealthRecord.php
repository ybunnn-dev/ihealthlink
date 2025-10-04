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
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'waist_circumference' => 'decimal:2',
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
