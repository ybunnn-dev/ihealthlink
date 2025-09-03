<?php

// Model 3: MedicineDistribution.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicineDistribution extends Model
{
    use HasFactory;

    public $timestamps = false; // Since we only have distributed_at

    protected $fillable = [
        'batch_id',
        'distributed_by',
        'amount',
        'distributed_at',
    ];

    protected $casts = [
        'distributed_at' => 'datetime',
    ];

    /**
     * Get the inventory batch this distribution belongs to
     */
    public function batch(): BelongsTo
    {
        return $this->belongsTo(MedicineInventory::class, 'batch_id');
    }

    /**
     * Get the user who distributed this medicine
     */
    public function distributedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'distributed_by');
    }

    /**
     * Get the medicine through the batch relationship
     */
    public function medicine()
    {
        return $this->batch->medicine();
    }

    /**
     * Automatically set distributed_at when creating
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($distribution) {
            if (!$distribution->distributed_at) {
                $distribution->distributed_at = now();
            }
        });
    }
}