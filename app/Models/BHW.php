<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BHW extends Model
{
    protected $table = 'personnel'; // same table as Midwife
    
    protected $fillable = [
        'user_id',
        'role_id',
        'brgy_id',
        'status',
        'added_by',
    ];

    protected static function booted()
    {
        static::addGlobalScope('bhw', function (Builder $builder) {
            $builder->where('role_id', 3);
        });
    }

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

    public function getNameAttribute()
    {
        $user = $this->users;
        if (!$user) return null;

        return trim("{$user->firstName} {$user->lastName} " . ($user->suffix ?? ''));
    }

    protected $appends = ['name'];
}
