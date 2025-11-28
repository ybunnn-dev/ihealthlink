<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ProjectCrypt;
use App\Models\PasswordResetToken;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function requestPassChangeChange(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Don't encrypt here - query with plaintext
        // Laravel will need to decrypt all emails to compare (inefficient but necessary)
        
        // Better approach: Get all users and find match
        $user = User::all()->first(function ($u) use ($request) {
            return $u->email === $request->email;  // Accessor decrypts automatically
        });

        if (! $user) {
            return response()->json([
                'message' => 'No account found with that email address.'
            ], 404);
        }

        $plainToken = mt_rand(100000, 999999);

        // Store the encrypted email in reset tokens
        $encryptedEmail = ProjectCrypt::encrypt($request->email);
        
        PasswordResetToken::updateOrCreate(
            ['email' => $encryptedEmail],
            [
                'token' => Hash::make($plainToken),
                'created_at' => now(),
            ]
        );

        Mail::raw("Your password reset code is: {$plainToken}", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Password Reset Verification Code');
        });

        return response()->json([
            'message' => 'A verification code has been sent to your email.'
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        // Only fetch recent tokens (last hour) to limit decryption operations
        $reset = PasswordResetToken::where('created_at', '>=', now()->subHour())
            ->get()
            ->first(function ($record) use ($request) {
                $decryptedEmail = ProjectCrypt::decrypt($record->email);
                return $decryptedEmail === $request->email;
            });

        if (! $reset) {
            return response()->json(['message' => 'No reset request found for this email.'], 404);
        }

        // Check if code is correct
        if (! Hash::check($request->code, $reset->token)) {
            return response()->json(['message' => 'Invalid verification code.'], 400);
        }

        // Check expiration (30 minutes)
        if (now()->diffInMinutes($reset->created_at) > 30) {
            return response()->json(['message' => 'Verification code expired.'], 400);
        }

        return response()->json([
            'message' => 'Verification successful.',
            'result' => 'success'
        ]);
    }

    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        // Find the record that matches the provided code
        $resetRecord = PasswordResetToken::all()->first(function ($record) use ($request) {
            return Hash::check($request->code, $record->token);
        });

        if (! $resetRecord) {
            return response()->json(['message' => 'Invalid or expired token.'], 400);
        }

        // Optional: Check if the token is expired (e.g., 30 minutes)
        if (now()->diffInMinutes($resetRecord->created_at) > 30) {
            return response()->json(['message' => 'Token has expired.'], 400);
        }

        // Get the associated user
        $user = User::where('email', $resetRecord->email)->first();

        if (! $user) {
            return response()->json(['message' => 'No user found for this token.'], 404);
        }

        // Update the user’s password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Delete the token after successful reset
        $resetRecord->delete();

        return response()->json([
            'message' => 'Password has been reset successfully.',
            'result' => 'success'
        ]);
    }
}
