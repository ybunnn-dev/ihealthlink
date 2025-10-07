<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaternityScreening extends Model
{
    use HasFactory;

    protected $table = 'maternity_screenings';

    protected $fillable = [
        'maternal_record_id',
        'syphilis_screening_date',
        'syphilis_screening_result',
        'hepatitis_b_screening_date',
        'hepatitis_b_screening_result',
        'hiv_screening_date',
        'hiv_screening_result',
        'gestational_diabetes_screening_date',
        'gestational_diabetes_result',
        'cbc_screening_date',
        'cbc_result',
        'given_iron',
    ];

    /**
     * Relationship with BasicMaternalRecord
     */
    public function maternalRecord()
    {
        return $this->belongsTo(BasicMaternalRecord::class, 'maternal_record_id');
    }
}
