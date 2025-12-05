<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MidwifeAndAssistantOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user || $user->status !== 'active') {
            abort(403, 'Account is not active');
        }
        
        if (!in_array($user->role_id, [2, 4])) {
           
            abort(403, 'Access denied. Midwife or Authorized BHW access required.');
        }
        
        return $next($request);
    }
}