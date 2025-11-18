<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedules;

class Midwife extends Model
{
    protected $table = 'personnel'; // use personnel table
    
    protected $fillable = [
        'user_id',
        'role_id',
        'brgy_id',
        'status',
        'added_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function getNameAttribute()
    {
        $user = $this->user;
        if (!$user) return null;

        // Example: "Peter Montefalco Jr."
        return trim("{$user->firstName} {$user->lastName} " . ($user->suffix ?? ''));
    }

    public function schedules()
    {
        return $this->hasManyThrough(
            Schedules::class, // final model
            self::class,                  // intermediate model (personnel / midwife)
            'brgy_id',                    // Foreign key on personnel table (brgy_id)
            'brgy_id',                    // Foreign key on schedules table (brgy_id)
            'id',                         // Local key on midwife (personnel) table
            'brgy_id'                     // Local key on schedules table (actually matches brgy_id)
        );
    }

    protected $appends = ['name'];
}
