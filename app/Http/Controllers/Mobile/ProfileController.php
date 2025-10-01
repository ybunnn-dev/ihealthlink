<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


use App\Models\EmailChange;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load([
            'role',
            'bhw.barangays',
        ]);

        return response()->json($user);
    }

    public function requestEmailChange(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_email' => 'required|email|unique:users,email',
        ]);

        if (! Hash::check($request->password, $request->user()->password)) {
            return response()->json([
                'message' => 'The provided password is incorrect.'
            ], 401);
        }

        \Log::info('vakla');
        
        $user = $request->user();
        $plainCode = mt_rand(100000, 999999); // e.g., 123456
        $hashedCode = Hash::make($plainCode);

        // Save pending change using Eloquent
        $emailChange = EmailChange::updateOrCreate(
            ['user_id' => $user->id],
            [
                'new_email' => $request->new_email,
                'verification_code' => $hashedCode,
                'expires_at' => now()->addMinutes(30)
            ]
        );

        // Send plain code to new email
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

        // Update user's email
        $user->email = $pending->new_email;
        $user->save();

        // Delete the pending email change
        $pending->delete();

        return response()->json(['message' => 'Email successfully updated']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8', // expects new_password_confirmation field
        ]);

        \Log::info($request->old_password);
        
        $user = $request->user();

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'], 400);
        }

        // Update to new password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password successfully updated']);
    }
}
