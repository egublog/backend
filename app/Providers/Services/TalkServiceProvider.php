<?php

namespace App\Providers\Services;

use Illuminate\Support\ServiceProvider;

class TalkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        // app()->bind(
        //     \App\Services\Talk\Interfaces\TalkDataSaveServiceInterface::class,
        //     \App\Services\Talk\Services\TalkDataSaveService::class
        // );
        app()->bind(
            \App\Services\Talk\Interfaces\TalkDataServiceInterface::class,
            \App\Services\Talk\Services\TalkDataService::class
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
