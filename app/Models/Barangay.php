<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ProjectCrypt;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'status'];

     protected $encryptable = [
        'name',
    ];

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
     * 🔓 CRITICAL FIX: Override attributesToArray to decrypt before JSON serialization
     * This ensures that when models are converted to JSON (e.g., @json($residents)),
     * encrypted fields are properly decrypted for frontend consumption.
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
    // One Barangay has many Puroks
    // Barangay.php
    public function puroks()
    {
        return $this->hasMany(Purok::class, 'brgy_id')
            ->where('status', 'active');
    }


    // Barangay belongs to a User (e.g., captain, head)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One Barangay has many Midwives
    public function midwives()
    {
        return $this->hasMany(Midwife::class, 'brgy_id'); // match your actual column
    }
    public function bhw()
    {
        return $this->hasMany(BHW::class, 'brgy_id');
    }
    public function bhwWeb()
    {
        return $this->hasMany(BHW::class, 'brgy_id')->where('role_id', 4);
    }

    public function personnel(){
        return $this->hasMany(Personnel::class, 'brgy_id');
    }

}
