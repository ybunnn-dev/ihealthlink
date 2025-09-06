<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyActivities extends Model
{
    protected $fillable = [
        'day',
        'brgy_id',
        'icon_id',
        'updated_by',
        'activities', // since you added this column
    ];

    // Link to the activity icon
    public function icon()
    {
        return $this->belongsTo(ActivityIcons::class, 'icon_id');
    }

    // Link to the barangay
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }

    // Link to the user who updated
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
