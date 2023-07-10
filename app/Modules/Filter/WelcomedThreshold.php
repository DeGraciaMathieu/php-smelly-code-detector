<?php

namespace App\Modules\Filter;

use App\Modules\Filter\Dtos\Thresholds;

class WelcomedThreshold
{
    public static function passes(array $method, Thresholds $thresholds): bool
    {
        if (self::outsideMinThreshold($method, $thresholds)) {
            return false;
        }

        if (self::outsideMaxThreshold($method, $thresholds)) {
            return false;
        }

        return true;
    }

    private static function outsideMinThreshold(array $method, Thresholds $thresholds): bool
    {
        return $thresholds->min && $method['smell'] < (int) $thresholds->min;
    }

    private static function outsideMaxThreshold(array $method, Thresholds $thresholds): bool
    {
        return $thresholds->max && $method['smell'] > (int) $thresholds->max;
    }
}
