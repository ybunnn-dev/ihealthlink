<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyOutcome extends Model
{
    use HasFactory;

    protected $table = 'pregnancy_outcomes';

    protected $fillable = [
        'basic_maternal_record_id',
        'date_terminated',
        'outcome',
        'sex',
        'delivery_type',
        'birth_weight',
        'delivery_place_type',
        'is_bemonc_cemonc_capable',
        'delivery_place_ownership',
        'birth_attendant',
        'remarks',
        'delivery_datetime',
    ];

    /**
     * Relationship with BasicMaternalRecord
     */
    public function basicMaternalRecord()
    {
        return $this->belongsTo(BasicMaternalRecord::class, 'basic_maternal_record_id');
    }

    /**
     * Accessor for formatted birth weight (optional)
     */
    public function getFormattedBirthWeightAttribute()
    {
        return number_format($this->birth_weight, 2) . ' kg';
    }

    /**
     * Accessor for full delivery place description (optional)
     */
    public function getDeliveryPlaceDescriptionAttribute()
    {
        return $this->delivery_place_type . ' (' . ucfirst(strtolower($this->delivery_place_ownership)) . ')';
    }
}
