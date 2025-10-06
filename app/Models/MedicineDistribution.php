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
        'medicine_id',
        'distributed_by',
        'consultation_id',
        'quantity',
    ];
    /**
     * Get the inventory batch this distribution belongs to
     */
    public function medicine(): BelongsTo
    {
        return $this->belongsTo(MedicineInventory::class, 'medicine_id');
    }

    /**
     * Get the user who distributed this medicine
     */
    public function distributedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'distributed_by');
    }

    public function consultation(){
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }
    /**
     * Automatically set distributed_at when creating
     */

}