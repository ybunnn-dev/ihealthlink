<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBarangayAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        // Check if user is active
        if (!$user || $user->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Account is not active.'
            ], 403);
            abort(403, 'Account is not active');
        }
        
        // Skip for admins (they can access all barangays)
        if ($user->role_id === 1) {
            return $next($request);
        }
        
        // Check if user has barangay assigned
        if (!$user->brgy_id) {
            abort(403, 'This account has no barangay.');
        }
        
        // Attach barangay ID to request for easy access in controllers
        $request->merge(['user_brgy_id' => $user->brgy_id]);
        
        return $next($request);
    }
}
