<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function getNextConsultationAttribute()
    {
        $today = Carbon::now('Asia/Manila')->startOfDay();

        // ✅ If the enrollment itself is already done/terminated, stop here
        if (in_array($this->status, ['completed', 'terminated'])) {
            return [
                'status' => ucfirst($this->status), // "Completed" or "Terminated"
                'color'  => $this->status === 'completed'
                    ? 'bg-green-100 text-green-800'
                    : 'bg-gray-100 text-gray-800',
                'date'   => 'N/A',
            ];
        }

        $pending = $this->consultations
            ->where('status', 'pending')
            ->whereNotNull('consultation_date')
            ->sortBy('consultation_date');

        if ($pending->isEmpty()) {
            return [
                'status' => 'Completed',
                'color'  => 'bg-green-100 text-green-800',
                'date'   => 'N/A',
            ];
        }

        // Always get the *first pending* consultation
        $next = $pending->first();
        $date = Carbon::parse($next->consultation_date)->startOfDay();

        if ($date->lt($today)) {
            $status = 'Late';
            $color  = 'bg-red-100 text-red-800';
        } elseif ($date->isSameDay($today)) {
            $status = 'Today';
            $color  = 'bg-yellow-100 text-yellow-800';
        } else {
            $status = 'Upcoming';
            $color  = 'bg-blue-100 text-blue-800';
        }

        return [
            'status' => $status,
            'color'  => $color,
            'date'   => $date->format('M d, Y'),
        ];
    }

    public function maternalRecords()
    {
        return $this->hasMany(BasicMaternalRecord::class, 'resident_id');
    }

}
