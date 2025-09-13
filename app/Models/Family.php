<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_id',
        'head_id',
        'status',
        'is_indigent',
        'is_4ps',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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
