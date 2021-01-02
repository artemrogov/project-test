<?php


namespace App\MyFacades;


use Illuminate\Support\Facades\Facade;

class Math extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'my_math';
    }

}
