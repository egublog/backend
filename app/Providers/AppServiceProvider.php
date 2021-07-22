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
        $this->RegisterForRepositories();

        $this->RegisterForUseCases();
        // app()->bind(
        //     \App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface::class,
        //     \App\packages\Domain\Application\User\GetAuthUserInteractor::class
        // );
        // app()->bind(
        //     \App\packages\Domain\Domain\User\UserRepositoryInterface::class,
        //     \App\packages\Infrastructure\User\UserRepository::class
        // );
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

    private function RegisterForRepositories(){
        app()->bind(
            \App\packages\Domain\Domain\User\UserRepositoryInterface::class,
            \App\packages\Infrastructure\User\UserRepository::class
        );
        app()->bind(
            \App\packages\Domain\Domain\Era\EraRepositoryInterface::class,
            \App\packages\Infrastructure\Era\EraRepository::class
        );
        app()->bind(
            \App\packages\Domain\Domain\Team\TeamRepositoryInterface::class,
            \App\packages\Infrastructure\Team\TeamRepository::class
        );
        app()->bind(
            \App\packages\Domain\Domain\Talk\TalkRepositoryInterface::class,
            \App\packages\Infrastructure\Talk\TalkRepository::class
        );
        app()->bind(
            \App\packages\Domain\Domain\Talk_list\Talk_listRepositoryInterface::class,
            \App\packages\Infrastructure\Talk_list\Talk_listRepository::class
        );
        app()->bind(
            \App\packages\Domain\Domain\Follow\FollowRepositoryInterface::class,
            \App\packages\Infrastructure\Follow\FollowRepository::class
        );
    }
    
    private function RegisterForUseCases() {
        app()->bind(
            \App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface::class,
            \App\packages\Domain\Application\User\GetAuthUserInteractor::class
        );
        
    }
}
