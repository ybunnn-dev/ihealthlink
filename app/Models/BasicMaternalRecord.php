<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class BasicMaternalRecord extends Model
{
    use HasFactory;

    protected $table = 'basic_maternal_records';

    protected $fillable = [
        'resident_id',
        'last_menstrual_period',
        'gravida',
        'para',
        'expected_date_of_confinement',
    ];

    /**
     * Relationship: belongs to a resident
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    /**
     * Mutator: Auto-compute EDC when LMP is set
     */
    public function setLastMenstrualPeriodAttribute($value)
    {
        $this->attributes['last_menstrual_period'] = $value;

        // Compute EDC using Naegele’s Rule
        $lmp = Carbon::parse($value);
        $edc = $lmp->copy()->addYear()->subMonths(3)->addDays(7);

        $this->attributes['expected_date_of_confinement'] = $edc->toDateString();
    }
}
