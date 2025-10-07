<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidenceHistory extends Model
{
    use HasFactory;

    protected $table = 'residence_history';

    // Fillable fields for mass assignment
    protected $fillable = [
        'resident_id',
        'purok_id',
        'status',
        'created_at',
        'updated_at',
    ];

    // Define relationships

    /**
     * The resident this history belongs to.
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * The barangay this history belongs to.
     */
    public function purok()
    {
        return $this->belongsTo(Purok::class, 'purok_id');
    }

    /**
     * Scope to only active residence histories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
