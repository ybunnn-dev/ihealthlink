<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPersonnelRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        // Block admins (role_id === 1)
        if ($user->role_id === 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied. Admins cannot access this resource.'
            ], 403);
        }
        
        // Only allow BHWs, Midwives (role_id 2, 3, etc.)
        if (!in_array($user->role_id, [2, 3, 4])) { // Adjust role IDs
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ], 403);
        }
        
        return $next($request);
    }
}