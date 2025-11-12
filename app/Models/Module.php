<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        //this supposedly has an id
        'module_name',
    ];

    // A module can have many user manuals
    public function userManuals()
    {
        return $this->hasMany(UserManual::class);
    }
}
