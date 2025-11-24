<?php

namespace App\Providers;

use App\Auth\EncryptedEmailUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register custom encrypted email user provider
        Auth::provider('encrypted', function ($app, array $config) {
            return new EncryptedEmailUserProvider($app['hash'], $config['model']);
        });
    }
}
