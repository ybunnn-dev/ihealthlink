<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequestIp
{

    public function handle($request, Closure $next)
    {
        $user = $request->user();

        \Log::info('API Request', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user' => $user ? $this->formatName($user) : null,
        ]);

        return $next($request);
    }

    private function formatName($user)
    {
        $parts = [
            $user->firstName,
            $user->middleName,
            $user->lastName,
            $user->suffix,
        ];

        return trim(collect($parts)->filter()->join(' '));
    }

}
