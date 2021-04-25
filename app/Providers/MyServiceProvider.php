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
        app()->singleton('commonservice', 'App\MyClasses\CommonService');
        app()->singleton('profile', 'App\MyClasses\Profile');

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
