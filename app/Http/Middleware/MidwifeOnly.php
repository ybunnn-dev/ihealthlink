<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MidwifeOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user || $user->status !== 'active') {
            abort(403, 'Account is not active');
        }
        
        if ($user->role_id !== 2) {
            abort(403, 'Access denied. Midwife access required.');
        }
        
        return $next($request);
    }
}