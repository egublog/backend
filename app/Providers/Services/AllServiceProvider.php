<?php

namespace App\Providers\Services;

use Illuminate\Support\ServiceProvider;

class AllServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        app()->bind(
            \App\Services\All\Interfaces\AllDataSaveServiceInterface::class,
            \App\Services\All\Services\AllDataSaveService::class
        );
        app()->bind(
            \App\Services\All\Interfaces\AllDataAccessServiceInterface::class,
            \App\Services\All\Services\AllDataAccessService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
