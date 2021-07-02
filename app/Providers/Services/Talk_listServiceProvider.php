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
            \App\Services\Talk_list\Interfaces\TalkListDataAccessServiceInterface::class,
            \App\Services\Talk_list\Services\TalkListDataAccessService::class
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
