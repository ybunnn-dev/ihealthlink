<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyPlanningData extends Model
{
    use HasFactory;

    // Table name (optional if it matches plural form)
    protected $table = 'family_planning_data';

    // Primary key
    protected $primaryKey = 'id';

    // Indicates if the IDs are auto-incrementing
    public $incrementing = true;

    // Key type
    protected $keyType = 'int';

    // Timestamps (created_at, updated_at)
    public $timestamps = true;

    // Mass assignable attributes
    protected $fillable = [
        'client_type',
        'source',
        'previous_method',
        'dropout_date',
        'dropout_reason',
        'enrolled_resident_id',
    ];

    /**
     * Relationships
     */

    // Each Family Planning Data record belongs to an enrolled resident
    public function enrolledResident()
    {
        return $this->belongsTo(EnrolledResident::class, 'enrolled_resident_id');
    }
}
