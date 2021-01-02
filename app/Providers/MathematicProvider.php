<?php

namespace App\Providers;

use App\MyClass\Mathematic;
use App\MyFacades\Math;
use Illuminate\Support\ServiceProvider;

class MathematicProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //первый способ через замыкание:
        /*$this->app->bind('my_math',function(){
            new Mathematic();
        });*/

        // второй способ:
        $this->app->bind(Math::class,Mathematic::class);

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
