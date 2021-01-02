<?php

namespace App\Providers;

use App\MyClass\HelloWorld;
use App\MyFacades\MyStrFacade;
use Illuminate\Support\ServiceProvider;

class HelloWorldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('hello_world',function(){
           return new HelloWorld();
        });
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
