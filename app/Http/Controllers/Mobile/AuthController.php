<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user = Auth::user();

        // Allow only roles 3 and 4 here
        if (!in_array($user->role_id, [3, 4])) {
            return response()->json(['message' => 'Unauthorized role for mobile login'], 403);
        }

        return response()->json([
            'message' => 'Login successful',
            'token'   => $user->createToken('mobile-token')->plainTextToken,
            'role'    => $user->role_id,
        ]);
    }
    public function logout(Request $request)
    {
        // Revoke the current token used in the request
        $user = $request->user(); // Authenticated user via Sanctum token

        if ($user) {
            $user->currentAccessToken()->delete(); // deletes only the current token
            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        }

        return response()->json([
            'message' => 'No user authenticated'
        ], 401);
    }

}
