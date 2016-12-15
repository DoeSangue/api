<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        $this->mapApiProtectedRoutes();
        $this->mapApiPublicRoutes();
    }

    /**
     * Define the api protected routes.
     */
    protected function mapApiProtectedRoutes()
    {
        $options = [
            'middleware' => ['jwt.auth', 'cors'],
            'namespace'  => $this->namespace,
        ];

        Route::group($options, function ($router) {
            require base_path('routes/api/protected.php');
        });
    }

    /**
     * Define the api public routes.
     */
    protected function mapApiPublicRoutes()
    {
        $options = [
            'middleware' => ['api', 'cors'],
            'namespace'  => $this->namespace,
        ];

        Route::group($options, function ($router) {
            require base_path('routes/api/public.php');
        });
    }
}
