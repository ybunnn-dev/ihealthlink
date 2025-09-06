<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personnel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personnel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'role_id',
        'brgy_id',
        'status',
        'added_by',
    ];

    /**
     * Get the user that owns the personnel record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the barangay associated with the personnel.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }
}