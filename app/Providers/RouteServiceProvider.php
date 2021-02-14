<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    /**
     *
     * @var string
     */
    protected $namespace = 'App\\Http\\Controllers';

    protected $namespace2 = 'App\\Http\\Pages';

    protected $namespace_cms = 'App\\CMS\\Http';

    protected $namespace_api_cms = 'App\\CMS\\API';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            /**
             * my routing
             */
            Route::middleware('web')
                ->namespace($this->namespace2)
                ->group(base_path('routes/test.php'));

            /**
             * CMS Routing
             */
            Route::middleware('web')
                ->namespace($this->namespace_cms)
                ->group(base_path('app/CMS/routes/routes_admin.php'));

            /**
             * CMS API Routing
             */
            Route::middleware('api')
                ->namespace($this->namespace_api_cms)
                ->group(base_path('app/CMS/api_routes/base_api_router.php'));

        });


    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
