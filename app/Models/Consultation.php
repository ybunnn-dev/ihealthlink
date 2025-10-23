<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Consultation extends Model
{
    use HasFactory;

    // Explicit table name (optional since Laravel infers plural of class name)
    protected $table = 'consultations';

    // Mass assignable attributes
    protected $fillable = [
        'resident_id',
        'enrolled_resident_id', //ignore this because this is for the health program only
        'consultation_date',
        'status',
        'is_pregnant',
        'is_lactating',
        'schedule_extension_days',
        'consultation_title',
        'uuid',
        'remarks', //ignore this
        'updated_by',
    ];

    // Casts for attributes
    protected $casts = [
        'consultation_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($consultation) {
            if (empty($consultation->uuid)) {
                $consultation->uuid = Str::uuid()->toString();
            }
        });
    }


    /**
     * Relationships
     */

    // Consultation belongs to a resident
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    // Consultation belongs to a health program
    public function program()
    {
        return $this->belongsTo(HealthProgram::class, 'program_id');
    }

    // Consultation updated by a user (e.g., midwife, admin)
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function enrolledResident(){
        return $this->belongsTo(EnrolledResident::class, 'enrolled_resident_id');
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
    
    public function riskAssessment()
    {
        return $this->hasOne(RiskAssessment::class);
    }
   
    public function ncdRiskFactor(){
        return $this->hasOne(NcdRiskFactor::class);
    }

    public function philpenManagement(){
        return $this->hasOne(PhilpenManagement::class);
    }

    public function consultationData()
    {
        return $this->hasOne(ConsultationData::class, 'consultation_id');
    }

    public function medicineDistributions()
    {
        return $this->hasMany(MedicineDistribution::class, 'consultation_id');
    }
}
