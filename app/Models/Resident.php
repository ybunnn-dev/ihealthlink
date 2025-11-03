<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\ProjectCrypt;
use Illuminate\Support\Str;



class Resident extends Model
{
    use HasFactory;

   protected $fillable = [
        'family_id',
        'added_by',
        'firstName',
        'lastName',
        'purok_id',
        'middleName',
        'suffix',
        'birthdate',
        'sex',
        'contact_no',
        'civil_status',
        'family_relationship',
        'philhealth_no',
        'educational_attainment',
        'is_pwd',
        'pwd_id',
        'is_indigenous',
        'if_philhealth',
        'if_solo_parent',
        'employment_status',
        'status',
        'religion',
        'ethnicity',
        'emergencyContactNo',
        'client_uuid'
    ];

    // Fields that should be automatically encrypted/decrypted
    protected $encryptable = [
        'firstName',
        'lastName',
        'middleName',
        'contact_no',
        'pwd_id',
        'emergencyContactNo',
        'birthdate',
        'suffix'
    ];

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resident) {
            if (empty($resident->client_uuid)) {
                $resident->client_uuid = Str::uuid()->toString();
            }
        });
    }
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

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    
    // A resident belongs to a family
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    // A resident can be head of a household (nullable foreign key)
    public function householdHead()
    {
        return $this->hasOne(Household::class, 'head_id');
    }

    // A resident is added by a user (nullable foreign key)
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    

    public function enrolledResidents()
    {
        return $this->hasMany(EnrolledResident::class, 'resident_id');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'resident_id');
    }
    
    public function maternalRecords()
    {
        return $this->hasMany(BasicMaternalRecord::class, 'resident_id');
    }
    
    public function residenceHistory()
    {
        return $this->hasMany(ResidenceHistory::class, 'resident_id');
    }

    public function residenceHistories()
    {
        return $this->hasMany(ResidenceHistory::class, 'resident_id');
    }
    
    public function basicHealthRecord()
    {
        return $this->hasOne(BasicHealthRecord::class);
    }
    public function children(){
        return $this->hasMany(ChildHealthcare::class);
    }

}