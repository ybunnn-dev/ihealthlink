<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityIcons extends Model
{
    protected $fillable = [
        'path', // the <path> for the SVG
    ];

    // Optional: link back to daily activities
    public function dailyActivities()
    {
        return $this->hasMany(DailyActivities::class, 'icon_id');
    }
}
