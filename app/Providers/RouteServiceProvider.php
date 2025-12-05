<?php

namespace App\Providers;

use App\Helpers\ProjectCrypt;
use App\Models\Personnel;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * @var string|null
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        parent::boot();

        // Encrypted binding for personnel (applies to all web routes)
        Route::bind('personnel', function ($value) {
            // Only decrypt for non-API routes
            if (request()->is('api/*')) {
                return Personnel::findOrFail($value); 
            }

            $id = ProjectCrypt::decrypt($value);

            if (!$id) abort(404);
            return Personnel::findOrFail($id);
        });

    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        // If your Laravel version is 10 or older:
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
}