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
        'uuid',
        'resident_id',
        'weight',
        'height',
        'weight_grams',
        'status',
        'health_records',
        'waist_circumference',
        'systolic_pressure',
        'diastolic_pressure',
        'is_pregnant',
        'is_lactating',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($record) {
            if (empty($record->uuid)) {
                $record->uuid = Str::uuid()->toString();
            }
        });
    }
    /**
     * Relationship: A basic health record belongs to a resident.
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
