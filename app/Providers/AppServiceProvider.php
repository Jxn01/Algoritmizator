<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        if ($this->app->environment('testing')) {
            //use the routes in routes/test.php
            $this->loadRoutesFrom(base_path('routes/test.php'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
