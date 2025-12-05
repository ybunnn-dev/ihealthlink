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
                abort(403, 'Account is not active.');
            }
            
            return redirect()->route('home')
                ->with('error', 'Your account has been deactivated. Please contact administrator.');
        }
        
        if ($user->role_id !== 1) {
            if ($request->expectsJson()) {
                abort(403, 'Access denied. Admin access required');
            }
            
            return redirect()->route('home')
                ->with('error', 'Access denied. Admin privileges required.');
        }
        
        return $next($request);
    }
}
