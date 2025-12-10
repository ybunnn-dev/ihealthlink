<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Helpers\ProjectCrypt;


use App\Models\EmailChange;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load([
            'role',
            'personnel.barangay',
        ]);

        return response()->json($user);
    }

    public function requestEmailChange(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_email' => 'required|email', 
        ]);

        if (! Hash::check($request->password, $request->user()->password)) {
            return response()->json([
                'message' => 'The provided password is incorrect.'
            ], 401);
        }

        // Check if email already exists by decrypting all users
        $emailExists = User::all()->first(function ($u) use ($request) {
            return $u->email === $request->new_email;
        });

        if ($emailExists) {
            return response()->json([
                'message' => 'This email is already in use.'
            ], 422);
        }

        $user = $request->user();
        $plainCode = mt_rand(100000, 999999);
        $hashedCode = Hash::make($plainCode);

        EmailChange::where('user_id', $user->id)->delete();

        // Encrypt the new email before storing
        $encryptedNewEmail = $request->new_email;

        $emailChange = EmailChange::updateOrCreate(
            ['user_id' => $user->id],
            [
                'new_email' => $encryptedNewEmail,  
                'verification_code' => $hashedCode,
                'expires_at' => now()->addMinutes(30)
            ]
        );

        // Send plain code to new email (use plaintext for sending)
        Mail::raw("Your verification code is: $plainCode", function ($message) use ($request) {
            $message->to($request->new_email)
                    ->subject('Email Change Verification Code');
        });

        return response()->json(['message' => 'Verification code sent to new email']);
    }


    public function verifyEmailChange(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = $request->user();

        // Get pending email change for this user
        $pending = EmailChange::where('user_id', $user->id)
            ->where('expires_at', '>', now())
            ->first();

        // Check if code exists and matches hashed code
        if (!$pending || !Hash::check($request->code, $pending->verification_code)) {
            return response()->json(['message' => 'Invalid or expired code'], 400);
        }

        $decryptedNewEmail = $pending->new_email;
        
        $user->email = $decryptedNewEmail;
        $user->save();

        // Delete the pending email change
        $pending->delete();

        return response()->json(['message' => 'Email successfully updated']);
    }


    public function resendEmailChange(Request $request)
    {
        $user = $request->user();

        $latestRequest = EmailChange::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if (! $latestRequest) {
            return response()->json([
                'message' => 'No pending email change request found.'
            ], 404);
        }

        // Decrypt the new email to send mail
        $decryptedNewEmail = $latestRequest->new_email;

        $latestRequest->delete();

        $plainCode = mt_rand(100000, 999999);
        $hashedCode = Hash::make($plainCode);

        EmailChange::create([
            'user_id' => $user->id,
            'new_email' => $latestRequest->new_email,  // Already encrypted from previous request
            'verification_code' => $hashedCode,
            'expires_at' => now()->addMinutes(30)
        ]);

        // Send to decrypted email
        Mail::raw("Your verification code is: $plainCode", function ($message) use ($decryptedNewEmail) {
            $message->to($decryptedNewEmail)
                    ->subject('Email Change Verification Code');
        });

        return response()->json([
            'message' => 'A new verification code has been sent to your email.'
        ]);
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8', // expects new_password_confirmation field
        ]);
        
        $user = $request->user();

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'], 400);
        }

        // Update to new password
        $user->password = Hash::make($request->new_password);
        $user->is_pass_updated = 1;
        $user->save();

        return response()->json(['message' => 'Password successfully updated']);
    }
}
