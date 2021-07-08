<?php

namespace App\Providers\Services;

use Illuminate\Support\ServiceProvider;

class Talk_listServiceProvider extends ServiceProvider
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
            \App\Services\Talk_list\Interfaces\TalkListDataServiceInterface::class,
            \App\Services\Talk_list\Services\TalkListDataService::class
        );
        // app()->bind(
        //     \App\Services\Talk_list\Interfaces\TalkListDataSaveServiceInterface::class,
        //     \App\Services\Talk_list\Services\TalkListDataSaveService::class
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
