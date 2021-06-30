<?php

namespace App\Providers\Services;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
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
            \App\Services\User\Interfaces\UserDataSaveServiceInterface::class,
            \App\Services\User\Services\UserDataSaveService::class
        );
        app()->bind(
            \App\Services\User\Interfaces\UserDataAccessServiceInterface::class,
            \App\Services\User\Services\UserDataAccessService::class
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
