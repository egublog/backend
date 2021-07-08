<?php

namespace App\Providers\Repositories;

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
            \App\Repositories\All\Interfaces\AllDataRepositoryInterface::class,
            \App\Repositories\All\Repositories\AllDataRepository::class
        );
        // app()->bind(
        //     \App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface::class,
        //     \App\Repositories\All\Repositories\AllDataSaveRepository::class
        // );
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
