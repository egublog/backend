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
            \App\Repositories\User\Interfaces\UserDataAccessInterface::class,
            \App\Repositories\User\Repositories\UserDataAccessRepository::class
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
