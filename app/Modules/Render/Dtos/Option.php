<?php

namespace App\Modules\Render\Dtos;

use App\Modules\Render\Enums\RenderType;

class Option
{
    public function __construct(
        public RenderType $type,
    ) {}

    public static function fromCommand(array $attributes): Option
    {
        $type = $attributes['json'] ? RenderType::Json : RenderType::View;

        return new self($type);
    }
}
