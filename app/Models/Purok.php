<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ProjectCrypt;

class Purok extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brgy_id', 'status'];

    protected $encryptable = [
        'name',
    ];

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable) && $value !== null) {
            $value = ProjectCrypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    /* Automatically Decrypt When Accessing */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable) && $value !== null) {
            $decrypted = ProjectCrypt::decrypt($value);
            return $decrypted ?? $value; // fallback if decrypt fails
        }

        return $value;
    }

    /**
     * CRITICAL FIX: Override attributesToArray to decrypt before JSON serialization
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->encryptable as $key) {
            if (isset($attributes[$key]) && $attributes[$key] !== null) {
                $decrypted = ProjectCrypt::decrypt($attributes[$key]);
                $attributes[$key] = $decrypted ?? $attributes[$key];
            }
        }

        return $attributes;
    }

    // One Purok belongs to one Barangay
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }
    
    public function households()
    {
        return $this->hasMany(Household::class);
    }
}