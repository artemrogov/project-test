<?php


namespace App\Casts;


use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DateCasting implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return Carbon::create($value)->format('d-m-Y');
    }

}
