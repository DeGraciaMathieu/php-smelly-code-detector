<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

use PhpParser\Node\Param;

class Argument
{
    protected static $attributes;

    public static function from(Param $attributes)
    {
        self::$attributes = $attributes;
    }

    public static function itsBoolean(): bool
    {
        $name = self::$attributes->type->name ?? null;

        return $name === 'bool';
    }

    public static function itsReference(): bool
    {
        return self::$attributes->byRef;
    }

    public static function itsNullable(): bool
    {
        return ! is_null(self::$attributes->default);
    }
}
