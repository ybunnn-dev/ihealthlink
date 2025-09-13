<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'purok_id',
        'head_id',
        'has_toilet',
        'water_source',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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

    // A household can have many residents (through families OR directly if you allow it)
    public function residents()
    {
        return $this->hasManyThrough(Resident::class, Family::class);
    }

    // A household may have one "head" (resident), nullable
    public function head()
    {
        return $this->belongsTo(Resident::class, 'head_id');
    }
}
