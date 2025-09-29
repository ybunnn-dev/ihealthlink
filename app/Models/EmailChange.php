<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'new_email',
        'verification_code',
        'expires_at',
    ];

    protected $dates = ['expires_at'];

    // Relationship to the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
