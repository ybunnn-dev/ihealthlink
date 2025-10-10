<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EnrolledResident extends Model
{
    use HasFactory;

    protected $table = 'enrolled_residents';

    protected $fillable = [
        'resident_id',
        'program_id',
        'enrolled_by',
        'updated_by',
        'status',
    ];

    /**
     * Relationships
     */

    // Link to resident
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    // Link to health program
    public function program()
    {
        return $this->belongsTo(HealthProgram::class);
    }

    // The user who enrolled the resident
    public function enrolledBy()
    {
        return $this->belongsTo(User::class, 'enrolled_by');
    }

    // The user who last updated the enrollment
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'resident_id', 'resident_id');
    }

    public function maternalRecord(){
        return $this->hasOne(BasicMaternalRecord::class);
    }
    public function famPlanRecord(){
        return $this->hasOne(FamilyPlanningData::class);
    }
    public function getNextConsultationAttribute($enrolledResidentId = null)
    {
        $today = Carbon::now('Asia/Manila')->startOfDay();

        // If the enrollment itself is already done/terminated
        if (in_array($this->status, ['completed', 'terminated'])) {
            return [
                'status' => ucfirst($this->status),
                'color'  => $this->status === 'completed'
                    ? 'bg-green-100 text-green-800'
                    : 'bg-gray-100 text-gray-800',
                'date'   => 'N/A',
            ];
        }

        // Use passed enrolledResidentId, otherwise default to $this->id
        $enrolledResidentId = $enrolledResidentId ?? $this->id;

        // Get consultations for this enrollment
        $pending = $this->consultations
            ->where('enrolled_resident_id', $enrolledResidentId)
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

}
