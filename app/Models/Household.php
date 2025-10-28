<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;


class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'purok_id',
        'client_uuid',
        'head_id',
        'sanitary_toilet',
        'water_source',
        'waste_disposal',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resident) {
            if (empty($resident->client_uuid)) {
                $resident->client_uuid = Str::uuid()->toString();
            }
        });
    }
    // A household belongs to a purok
    public function purok()
    {
        return $this->belongsTo(Purok::class);
    }

    // A household can have many families
    public function families()
    {
        return $this->hasMany(Family::class);
    }


    // A household may have one "head" (resident), nullable
    public function head()
    {
        return $this->belongsTo(Resident::class, 'head_id');
    }

    public function householdResidenceHistory(){
        return $this->hasMany(HouseholdResidenceHistory::class, 'household_id');
    }
}
