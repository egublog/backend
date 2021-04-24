<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        app()->singleton('identifyid', 'App\MyClasses\IdentifyId');
        app()->singleton('searchallses', 'App\MyClasses\SearchAllses');
        app()->singleton('talklist', 'App\MyClasses\TalkList');

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
