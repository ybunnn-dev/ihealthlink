<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $headers = $response->headers;
            
            $headers->remove('X-Powered-By');
            $headers->set('X-Frame-Options', 'DENY');
            $headers->set('X-Content-Type-Options', 'nosniff');
            $headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            $headers->set('Permissions-Policy', 'geolocation=(), microphone=()');
            $headers->set('X-XSS-Protection', '1; mode=block');

            // Check if we're in development with Vite
            $isDev = config('app.debug');
            $viteUrl = 'http://localhost:5173/'; // Default Vite dev server

            if ($isDev) {
                // Development CSP - allows Vite
                $csp = [
                    "default-src 'self'",
                    "img-src 'self' data: blob:",
                    "script-src 'self' 'unsafe-eval' 'unsafe-inline' {$viteUrl}",
                    "style-src 'self' 'unsafe-inline' {$viteUrl}",
                    "font-src 'self' data:",
                    "connect-src 'self' wss: ws: {$viteUrl}",
                    "frame-ancestors 'none'",
                    "base-uri 'self'",
                    "form-action 'self'",
                ];
            } else {
                // Production CSP - stricter
                $csp = [
                    "default-src 'self'",
                    "img-src 'self' data:",
                    "script-src 'self' 'unsafe-eval' 'unsafe-inline'",
                    "style-src 'self' 'unsafe-inline'",
                    "font-src 'self' data:",
                    "connect-src 'self' wss: ws:",
                    "frame-ancestors 'none'",
                    "base-uri 'self'",
                    "form-action 'self'",
                ];
            }
            
            $headers->set('Content-Security-Policy', implode('; ', $csp));
        }

        return $response;
    }
}