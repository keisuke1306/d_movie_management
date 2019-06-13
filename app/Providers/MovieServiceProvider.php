<?php

namespace App\Providers;

use App\Services\MovieService;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(MovieService::class, MovieService::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
