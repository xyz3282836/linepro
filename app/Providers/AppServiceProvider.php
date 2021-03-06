<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_DEBUG')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        if (env('APP_ENV') != 'production') {
            $this->app->register(\Orangehill\Iseed\IseedServiceProvider::class);
        }
    }
}
