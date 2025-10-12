<?php

namespace App\Http\Controllers\Mobile;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::all()->first(function ($u) use ($email) {
            return $u->email === $email; 
        });

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        Auth::login($user);

        // Allow only roles 3 and 4
        if (!in_array($user->role_id, [2, 3, 4])) {
            Auth::logout();
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
