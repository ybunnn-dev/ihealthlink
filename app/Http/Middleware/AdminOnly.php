<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user || $user->status !== 'active') {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Account is not active.'
                ], 403);
            }
            
            return redirect()->route('home')
                ->with('error', 'Your account has been deactivated. Please contact administrator.');
        }
        
        if ($user->role_id !== 1) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Access denied. Admin access required.'
                ], 403);
            }
            
            return redirect()->route('home')
                ->with('error', 'Access denied. Admin privileges required.');
        }
        
        return $next($request);
    }
}
