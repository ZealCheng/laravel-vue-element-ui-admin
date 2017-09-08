<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        /*Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));*/

        $domain = env('FRONT_DOMAIN', '');
        $prefix = env('FRONT_MODULE_PREFIX', '');

        $router = Route::middleware('web');

        if (!empty($domain)) {
            $router->domain($domain);
        }

        if (!empty($prefix)) {
            $router->prefix($prefix);
        }

        $router->namespace($this->namespace)->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
    /*Route::prefix('api')
         ->middleware('api')
         ->namespace($this->namespace.'\Api')
         ->group(base_path('routes/api.php'));*/

        $domain = env('API_DOMAIN', '');
        $prefix = env('API_MODULE_PREFIX', '');

        $router = Route::middleware('api');

        if (!empty($domain)) {
            $router->domain($domain);
        }

        if (!empty($prefix)) {
            $router->prefix($prefix);
        }

        $router->namespace($this->namespace.'\Api')->group(base_path('routes/api.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapAdminRoutes()
    {

        $domain = env('ADMIN_DOMAIN', '');
        $prefix = env('ADMIN_MODULE_PREFIX', '');

        $router = Route::middleware('admin');

        if (!empty($domain)) {
            $router->domain($domain);
        }

        if (!empty($prefix)) {
            $router->prefix($prefix);
        }

        $router->namespace($this->namespace.'\Admin')->group(base_path('routes/admin.php'));
    }
}
