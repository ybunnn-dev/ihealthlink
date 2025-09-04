<?php

// Model 1: Medicine.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'added_by',
        'medicine_name',
        'generic_name',
        'category',
        'form',
        'description',
    ];

    /**
     * Get the user who added this medicine
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * Get all inventory records for this medicine
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(MedicineInventory::class);
    }

    /**
     * Get all distributions through inventory batches
     */
    public function distributions()
    {
        return $this->hasManyThrough(MedicineDistribution::class, MedicineInventory::class, 'medicine_id', 'batch_id');
    }

    /**
     * Get total stock across all batches
     */
    public function getTotalStockAttribute(): int
    {
        return $this->inventories()->sum('stock');
    }

    /**
     * Get expired batches
     */
    public function expiredBatches()
    {
        return $this->inventories()->where('expiry_date', '<', now());
    }

    /**
     * Get batches expiring soon (within 30 days)
     */
    public function batchesExpiringSoon()
    {
        return $this->inventories()->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now());
    }
}
