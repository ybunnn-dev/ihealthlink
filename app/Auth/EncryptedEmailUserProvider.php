<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use App\Helpers\ProjectCrypt;

class EncryptedEmailUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) || !isset($credentials['email'])) {
            return null;
        }

        $users = $this->createModel()->newQuery()->get();

        foreach ($users as $user) {
            try {
                $decryptedEmail = $user->getRawOriginal('email');
                
                if ($decryptedEmail === $credentials['email']) {
                    return $user;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    }
}
