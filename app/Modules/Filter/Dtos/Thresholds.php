<?php

namespace App\Modules\Filter\Dtos;

class Thresholds
{
    public function __construct(
        public ?int $min,
        public ?int $max,
    ) {}

    public static function fromCommand(array $attributes): self
    {
        return new self(
            min: $attributes['min-smell'],
            max: $attributes['max-smell'],
        );
    }
}
