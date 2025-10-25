<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_id',
        'head_id',
        'status',
        'is_indigent',
        'is_iwas_gutom',
        'is_4ps',
        'client_uuid',
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
    
    // A family belongs to one household
    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    // A family can have many residents
    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    // A family may have one head (resident), nullable
    public function head()
    {
        return $this->belongsTo(Resident::class, 'head_id');
    }
    public function householdResidents()
    {
        return $this->hasManyThrough(Resident::class, Household::class, 'id', 'family_id');
    }

}
