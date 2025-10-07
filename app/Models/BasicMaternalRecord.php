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
        'enrolled_resident_id',
        'last_menstrual_period',
        'gravida',
        'para',
        'expected_date_of_confinement',
    ];

    /**
     * Relationship: belongs to a resident
     */
    public function enrolledResident()
    {
        return $this->belongsTo(EnrolledResident::class, 'enrolled_resident_id');
    }

    public function maternityScreening()
    {
        return $this->hasOne(MaternityScreening::class, 'maternal_record_id');
    }

    public function pregnancyOutcome()
    {
        return $this->hasOne(PregnancyOutcome::class, 'basic_maternal_record_id');
    }

    /**
     * Mutator: Auto-compute EDC when LMP is set
     */
}
