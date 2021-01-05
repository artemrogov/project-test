<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Простое преобразование типов, если мы хотим расширить тип
 * Создать свой тип
 * Class CustomeCastAttributes
 * @package App\Casts
 */
class CustomeCastAttributes implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return 'CT-'.$value.'ABC';
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return \Illuminate\Support\Str::of($value)
            ->after('CT-')
            ->before('ABC');
    }
}
