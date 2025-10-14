<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdResidenceHistory extends Model
{
    use HasFactory;

    protected $table = 'household_residence_histories';

    protected $fillable = [
        'household_id',
        'head_id',
        'purok_id',
        'water_source',
        'waste_disposal',
        'sanitary_toilet',
        'is_iwas_gutom_enrolled',
        'is_indigent',
        'status',
    ];

    /**
     * Relationships
     */

    // Each residence history belongs to one household
    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    // The household head (person)
    public function head()
    {
        return $this->belongsTo(Person::class, 'head_id');
    }

    // The purok where this residence is located
    public function purok()
    {
        return $this->belongsTo(Purok::class);
    }
}
