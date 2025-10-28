<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    // No auto-incrementing primary key
    public $incrementing = false;

    // No timestamps (since only created_at exists)
    public $timestamps = false;

    // Primary key is not 'id'
    protected $primaryKey = 'email';
    protected $keyType = 'string';

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}
