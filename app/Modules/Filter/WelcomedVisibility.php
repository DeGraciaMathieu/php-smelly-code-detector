<?php

namespace App\Modules\Filter;

use App\Enums\Visibility;
use App\Modules\Filter\Dtos\Visibilities;

class WelcomedVisibility 
{
    public static function passes(array $method, Visibilities $visibilities): bool
    {
        if (self::keepAllVisibilities($visibilities)) {
            return true;
        }

        return match ($method['visibility']) {
            Visibility::Public => $visibilities->public,
            Visibility::Private => $visibilities->private,
            Visibility::Protected => $visibilities->protected,
        };
    }

    private static function keepAllVisibilities($visibilities): bool
    {
        return ! in_array(true, [
            $visibilities->public,
            $visibilities->private,
            $visibilities->protected,
        ], true);
    }
}
