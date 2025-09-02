<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barangays()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
