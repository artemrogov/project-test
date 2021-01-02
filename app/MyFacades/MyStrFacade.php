<?php


namespace App\MyFacades;


use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class MyStrFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hello_world';
    }

}
