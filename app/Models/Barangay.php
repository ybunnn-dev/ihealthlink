<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    // One Barangay has many Puroks
    public function puroks()
    {
        return $this->hasMany(Purok::class, 'brgy_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
