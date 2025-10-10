<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhilpenManagement extends Model
{
    use HasFactory;

    protected $table = 'philpen_managements';

    protected $fillable = [
        'consultation_id',
        'is_lifestyle_modification',
        'is_anti_hypertensive',
        'is_insulin',
        'follow_up_date',
        'remarks',
    ];

    // Example relationship (optional)
     public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }
}
