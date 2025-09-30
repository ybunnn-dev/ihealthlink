<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'added_by',
        'firstName',
        'lastName',
        'middleName',
        'suffix',
        'birthdate',
        'sex',
        'contact_no',
        'civil_status',
        'family_relationship',
        'is_pwd',
        'pwd_id',
        'is_indigenous',
        'employment_status',
        'status',
        'religion',
        'ethnicity',
        'emergencyContactNo'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // A resident belongs to a family
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    // A resident can be head of a household (nullable foreign key)
    public function householdHead()
    {
        return $this->hasOne(Household::class, 'head_id');
    }

    // A resident can be head of a family (nullable foreign key)
    public function familyHead()
    {
        return $this->hasOne(Family::class, 'head_id');
    }

    // A resident is added by a user (nullable foreign key)
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function healthSigns()
    {
        return $this->hasOne(HealthSigns::class, 'resident_id');
    }

    public function medicalHistory()
    {
        return $this->hasOne(ResidentMedicalHistory::class, 'resident_id');
    }
    public function familyHistory()
    {
        return $this->hasOne(ResidentFamilyHistory::class);
    }
    public function ncdRiskFactor()
    {
        return $this->hasOne(NcdRiskFactor::class);
    }

    public function riskAssessment()
    {
        return $this->hasOne(RiskAssessment::class);
    }
    public function enrolledResidents()
    {
        return $this->hasMany(EnrolledResident::class, 'resident_id');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'resident_id');
    }

}
