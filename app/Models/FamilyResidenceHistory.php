<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyResidenceHistory extends Model
{
    use HasFactory;

    protected $table = 'family_residence_histories';

    protected $fillable = [
        'family_id',
        'purok_id',
        'is_indigent',
        'is_4ps',
        'is_iwas_gutom',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_indigent' => 'boolean',
        'is_4ps' => 'boolean',
    ];

    // Relationships
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function purok()
    {
        return $this->belongsTo(Purok::class);
    }
}
