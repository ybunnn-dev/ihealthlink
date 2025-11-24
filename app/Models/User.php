<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Helpers\ProjectCrypt;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'middleName',
        'suffix',
        'birthdate',
        'contact_no',
        'email',
        'email_view',
        'is_pass_updated',
        'password',
        'role_id',
        'sex',
        'civil_status',
        'religion',
        'status'
    ];

    protected $encryptable = [
        'firstName',
        'lastName',
        'middleName',
        'suffix',
        'birthdate',
        'contact_no',
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
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable) && $value !== null) {
            $value = ProjectCrypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
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
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     // A user can be a midwife
    public function midwife()
    {
        return $this->hasOne(Midwife::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function addedMedicines(): HasMany
    {
        return $this->hasMany(Medicine::class, 'added_by');
    }

    /**
     * Get all medicine inventories added by this user
     */
    public function addedInventories(): HasMany
    {
        return $this->hasMany(MedicineInventory::class, 'added_by');
    }

    /**
     * Get all medicine distributions made by this user
     */
    public function medicineDistributions(): HasMany
    {
        return $this->hasMany(MedicineDistribution::class, 'distributed_by');
    }

    // inside User.php
    public function bhw()
    {
        return $this->hasOne(BHW::class, 'user_id');
    }

    public function bhwWeb(){
        return $this->hasOne(BHW::class, 'user_id')->where('role_id', 4); //the role_id should be 4
    }
    public function residentsAdded()
    {
        return $this->hasMany(Resident::class, 'added_by');
    }

    public function barangay()
    {
        if ($this->role_id === 2) {
            return $this->midwife->belongsTo(Barangay::class, 'brgy_id');
        }

        if ($this->role_id === 3) {
            return $this->bhw->belongsTo(Barangay::class, 'brgy_id');
        }

        if ($this->role_id === 4) {
            return $this->personnel->belongsTo(Barangay::class, 'brgy_id');
        }
    }

    public function personnel(){
        return $this->hasOne(Personnel::class, 'user_id');
    }
}
