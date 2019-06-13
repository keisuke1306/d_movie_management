<?php

namespace App\Providers;

use App\Services\YoutubeClientService;
use Illuminate\Support\ServiceProvider;

class YoutubeClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(YoutubeClientService::class, YoutubeClientService::class);
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
