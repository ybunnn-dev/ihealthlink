<?php

// Model 2: MedicineInventory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicineInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'added_by',
        'batch_num',
        'stock',
        'date_received',
        'quantity_received',
        'expiry_date',
        'status'
    ];

    protected $casts = [
        'date_received' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get the medicine this inventory belongs to
     */
    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    /**
     * Get the user who added this inventory
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * Get all distributions for this batch
     */
    public function distributions(): HasMany
    {
        return $this->hasMany(MedicineDistribution::class, 'batch_id');
    }

    /**
     * Check if batch is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date < now();
    }

    /**
     * Check if batch is expiring soon (within 30 days)
     */
    public function getIsExpiringSoonAttribute(): bool
    {
        return $this->expiry_date <= now()->addDays(30) && $this->expiry_date >= now();
    }

    /**
     * Get total distributed amount for this batch
     */
    public function getTotalDistributedAttribute(): int
    {
        return $this->distributions()->sum('amount');
    }

    /**
     * Reduce stock when distributing
     */
    public function distribute(int $amount): bool
    {
        if ($this->stock >= $amount) {
            $this->decrement('stock', $amount);
            return true;
        }
        return false;
    }
}
