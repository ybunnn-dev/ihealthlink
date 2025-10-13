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
            return response()->json([
                'status' => 'error',
                'message' => 'Account is not active.'
            ], 403);
        }
        
        if (!in_array($user->role_id, [2, 4])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied. Midwife or Role 4 access required.'
            ], 403);
        }
        
        return $next($request);
    }
}