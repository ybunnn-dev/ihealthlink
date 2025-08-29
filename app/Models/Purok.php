<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purok extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brgy_id'];

    // One Purok belongs to one Barangay
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }
}
