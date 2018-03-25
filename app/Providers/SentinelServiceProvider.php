<?php

namespace App\Providers;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SentinelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
     public function boot(Router $router)
     {
       // Register the route middleware
       $router->middleware('sentinel.guest',    \App\Http\Middleware\SentinelGuest::class);
       $router->middleware('sentinel',          \App\Http\Middleware\SentinelAuth::class);
      
     }
     /**
      * Register the application services.
      *
      * @return void
      */
     public function register()
     {
         $this->app->register('Cartalyst\Sentinel\Laravel\SentinelServiceProvider');
     }
     /**
      * Get the services provided by the provider.
      *
      * @return array
      */
     public function provides()
     {
         return array('auth', 'sentry');
     }
}
