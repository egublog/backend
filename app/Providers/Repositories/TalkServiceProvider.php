<?php

namespace App\Providers\Repositories;

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
        app()->bind(
            \App\Repositories\Talk\Interfaces\TalkDataAccessRepositoryInterface::class,
            \App\Repositories\Talk\Repositories\TalkDataAccessRepository::class
        );
        app()->bind(
            \App\Repositories\Talk\Interfaces\TalkDataSaveRepositoryInterface::class,
            \App\Repositories\Talk\Repositories\TalkDataSaveRepository::class
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
