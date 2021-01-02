<?php


namespace App\MyClass;


class Mathematic
{
    const PI = 3.14;
    public static function sum($a,$b){
        return ($a + $b)/static::PI;
    }
}
