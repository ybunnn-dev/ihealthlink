<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->role_id === 2) {
                $view->with([
                    'barangayName' => Auth::user()->barangay->name,
                    'barangayId'   => Auth::user()->barangay->id,
                ]);
            }
        });
    }
}
