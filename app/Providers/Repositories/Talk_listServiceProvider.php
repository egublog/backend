<?php

namespace App\Providers\Repositories;

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
            \App\Repositories\Talk_list\Interfaces\TalkListDataRepositoryInterface::class,
            \App\Repositories\Talk_list\Repositories\TalkListDataRepository::class
        );
        // app()->bind(
        //     \App\Repositories\Talk_list\Interfaces\TalkListDataSaveRepositoryInterface::class,
        //     \App\Repositories\Talk_list\Repositories\TalkListDataSaveRepository::class
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
