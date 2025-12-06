<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register your middleware here
       //$middleware->append(\App\Http\Middleware\SecurityHeaders::class); //why am i having an issue with the charts and other ui whenever i renmove the commebnt?
       $middleware->alias([
            'admin.only' => \App\Http\Middleware\AdminOnly::class,
            'midwife.only' => \App\Http\Middleware\MidwifeOnly::class,
            'midwife.role4' => \App\Http\Middleware\MidwifeAndAssistantOnly::class,
            'personnel.only' => \App\Http\Middleware\CheckPersonnelRole::class,
            'check.barangay' => \App\Http\Middleware\CheckBarangayAccess::class,
            'role' => \App\Http\Middleware\CheckRole::class, // Most flexible
            'active' => \App\Http\Middleware\CheckStatus::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();