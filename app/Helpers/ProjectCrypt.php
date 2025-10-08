<?php

namespace App\Helpers;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Log;

class ProjectCrypt
{
    protected static function getEncrypter(): Encrypter
    {
        $key = env('PROJECT_CRYPT_KEY');

        if (!$key) {
            throw new \Exception('PROJECT_CRYPT_KEY not set in .env');
        }

        // If key is base64 encoded, decode it
        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        // Use the same cipher Laravel uses (AES-256-CBC by default)
        $cipher = config('app.cipher', 'AES-256-CBC');

        return new Encrypter($key, $cipher);
    }

    public static function encrypt($value)
    {
        if ($value === null) return null;

        try {
            return self::getEncrypter()->encrypt($value);
        } catch (\Exception $e) {
            Log::error('ProjectCrypt encryption failed: ' . $e->getMessage());
            return null;
        }
    }

    public static function decrypt($value)
    {
        if ($value === null) return null;

        try {
            return self::getEncrypter()->decrypt($value);
        } catch (\Exception $e) {
            Log::warning('ProjectCrypt decryption failed: ' . $e->getMessage());
            return null;
        }
    }
}
