<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(
            \App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface::class,
            \App\packages\Domain\Application\User\GetAuthUserInteractor::class
        );
        app()->bind(
            \App\packages\Domain\Domain\User\UserRepositoryInterface::class,
            \App\packages\Infrastructure\User\UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
