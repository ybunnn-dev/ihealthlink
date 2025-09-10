<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProgram extends Model
{
    use HasFactory;

    // Explicitly map to the table (optional since Laravel infers it)
    protected $table = 'health_programs';

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'status',
    ];

    // Casts (useful if you want `status` as string always)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
