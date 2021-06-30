<?php

namespace App\Providers\Repositories;

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
            \App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface::class,
            \App\Repositories\User\Repositories\UserDataAccessRepository::class
        );
        app()->bind(
            \App\Repositories\User\Interfaces\UserDataSaveRepositoryInterface::class,
            \App\Repositories\User\Repositories\UserDataSaveRepository::class
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
