<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use App\Helpers\ProjectCrypt;
use Illuminate\Support\Facades\Log;

class UniqueEncryptedEmail implements Rule
{
    protected $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    public function passes($attribute, $value)
    {
        Log::info('UniqueEncryptedEmail: Checking email', [
            'input_email' => $value,
            'exclude_user_id' => $this->userId
        ]);

        // Get all users
        $users = User::all();
        Log::info('UniqueEncryptedEmail: Total users found', ['count' => $users->count()]);

        foreach ($users as $user) {
            // Skip the current user during updates
            if ($this->userId && $user->id == $this->userId) {
                continue;
            }

            // Decrypt the stored email
            $decryptedEmail = ProjectCrypt::decrypt($user->email);
            
            Log::info('UniqueEncryptedEmail: Comparing emails', [
                'user_id' => $user->id,
                'encrypted_email' => substr($user->email, 0, 20) . '...',
                'decrypted_email' => $decryptedEmail,
                'input_email' => $value,
                'match' => strtolower($decryptedEmail) === strtolower($value)
            ]);
            
            // Compare decrypted email with the input value
            if ($decryptedEmail && strtolower($decryptedEmail) === strtolower($value)) {
                Log::warning('UniqueEncryptedEmail: Duplicate email found', [
                    'existing_user_id' => $user->id,
                    'email' => $value
                ]);
                return false; // Email already exists
            }
        }

        Log::info('UniqueEncryptedEmail: Email is unique');
        return true; // Email is unique
    }

    public function message()
    {
        return 'The email has already been taken.';
    }
}
