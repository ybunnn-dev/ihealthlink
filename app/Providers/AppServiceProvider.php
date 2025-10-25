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
            if (Auth::check() && (Auth::user()->role_id === 2 || Auth::user()->role_id === 3 || Auth::user()->role_id === 4)) {
                $view->with([
                    'barangayName' => "Brgy. ".Auth::user()->barangay->name,
                    'barangayId'   => Auth::user()->barangay->id,
                    'puroks' => Auth::user()->personnel->barangay->puroks
                ]);
            }else{
                $view->with([
                    'barangayName' => 'MHO Admin',
                    'barangayId'   => 1,
                ]);
            }
        });
    }
}
