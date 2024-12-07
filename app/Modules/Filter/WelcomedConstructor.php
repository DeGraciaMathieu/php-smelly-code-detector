<?php

namespace App\Modules\Filter;

class WelcomedConstructor
{
    public static function passes(array $method, bool $withoutConstructor): bool
    {
        if ($withoutConstructor) {
            return ! $method['constructor'];
        }

        return true;
    }
}
