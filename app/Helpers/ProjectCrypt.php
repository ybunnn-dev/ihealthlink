<?php

namespace App\Helpers;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Log;

class ProjectCrypt
{
    protected static function getEncrypter(): Encrypter
    {
        //  Use config() instead of env()
        $key = config('project.crypt_key');

        if (!$key) {
            throw new \Exception('PROJECT_CRYPT_KEY not set in .env or config/project.php');
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
            Log::error('ProjectCrypt encryption failed: ' . $e->getMessage(), [
                'value_type' => gettype($value),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    public static function decrypt($value)
    {
        if ($value === null) return null;

        try {
            return self::getEncrypter()->decrypt($value);
        } catch (\Exception $e) {
            Log::warning('ProjectCrypt decryption failed: ' . $e->getMessage(), [
                'value_preview' => substr($value, 0, 50),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
}