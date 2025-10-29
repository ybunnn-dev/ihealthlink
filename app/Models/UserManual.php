<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManual extends Model
{
    use HasFactory;

    protected $fillable = [
        'added_by',
        'module_id',
        'question',
        'category',
        'content',
        'action_type'
    ];

    // A user manual belongs to a module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // A user manual was added by a user
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
