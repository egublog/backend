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
            \packages\UseCase\User\Get\GetAuthUseUseCaseInterface::class,
            \packages\Domain\Application\User\GetAuthUserInteractor::class
        );
        app()->bind(
            \packages\Domain\Domain\User\UserRepositoryInterface::class,
            \packages\Infrastructure\User\UserRepository::class
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
