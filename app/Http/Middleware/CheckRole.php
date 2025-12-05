<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.'
            ], 401);
        }
        
        // Check if user is active
        if ($user->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Account is not active.'
            ], 403);
        }
        
        // Map role_id to role names
        $roleMap = [
            1 => 'mho',
            2 => 'midwife',
            3 => 'bhw',
            4 => 'bhwWeb', // Adjust name as needed
        ];
        
        $userRole = $roleMap[$user->role_id] ?? null;
        
        if (!$userRole || !in_array($userRole, $roles)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied. Insufficient permissions.'
            ], 403);
        }
        
        return $next($request);
    }
}