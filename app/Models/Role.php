<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relation to users (if you still need it)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relation to personnel
    public function personnel()
    {
        return $this->hasMany(Personnel::class, 'role_id');
    }

    // Optional shortcut for BHWs
    public function bhws()
    {
        return $this->personnel()->where('role_id', 3);
    }

    // Optional shortcut for Midwives
    public function midwives()
    {
        return $this->personnel()->where('role_id', 2);
    }
}
