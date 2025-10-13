<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.'
            ], 401);
        }
        
        if ($user->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Your account has been deactivated. Please contact administrator.'
            ], 403);
        }
        
        return $next($request);
    }
}