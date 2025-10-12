<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildHealthcare extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'child_immunization';

    // Allow mass assignment for these fields
    protected $fillable = [
        'enrolled_resident_id',
        'mother_id',
        'birth_weight',
        'initiated_breast_feed',
        'is_exclusive_breastfeed_1',
        'is_exclusive_breastfeed_2',
        'is_exclusive_breastfeed_3',
        'is_exclusive_breastfeed_4',
        'exclusive_breastfeed_date_1',
        'exclusive_breastfeed_date_2',
        'exclusive_breastfeed_date_3',
        'exclusive_breastfeed_date_4',
        'is_exclusive_breastfeed_6mos',
        'stopped_exclusive_breastfeed_date',
        'complementary_feeding_status',
        'fic_date',
        'cic_date',
        'remarks'
    ];

    // Define relationships
    public function enrolledResident()
    {
        return $this->belongsTo(EnrolledResident::class, 'enrolled_resident_id');
    }

    public function mother()
    {
        return $this->belongsTo(Resident::class, 'mother_id');
    }

    // Optional: accessors for formatted dates
    protected $casts = [
        'initiated_breast_feed' => 'date',
        'exclusive_breastfeed_date_1' => 'date',
        'exclusive_breastfeed_date_2' => 'date',
        'exclusive_breastfeed_date_3' => 'date',
        'exclusive_breastfeed_date_4' => 'date',
        'stopped_exclusive_breastfeed_date' => 'date',
        'fic_date' => 'date',
        'cic_date' => 'date',
    ];
}