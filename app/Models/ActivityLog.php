<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ProjectCrypt;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'id',
        'user_id',
        'module_id',
        'activity',
    ];

    protected $encryptable = [
        'activity'
    ];
    /**
     * Relationships
     */
        /*
    |--------------------------------------------------------------------------
    | Encryption/Decryption Methods
    |--------------------------------------------------------------------------
    */
    
    /* 🔒 Automatically Encrypt Before Saving */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable) && $value !== null) {
            $value = ProjectCrypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    /* 🔓 Automatically Decrypt When Accessing */
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
    // The user who performed the activity
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The module related to the activity
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Quick helper to log an activity
     */
    public static function log($userId, $moduleId, $activity)
    {
        return self::create([
            'user_id' => $userId,
            'module_id' => $moduleId,
            'activity' => $activity,
        ]);
    }
}
