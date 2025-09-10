<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'message' => 'Welcome to your homepage!',
            'user' => [
                'id'    => $user->id,
                'email' => $user->email,
                'role'  => $user->role_id,
            ],
            'features' => match ($user->role_id) {
                3 => ['schedule', 'messaging', 'advocacies'],
                4 => ['messaging', 'advocacies'],
                default => [],
            },
        ]);
    }
}
