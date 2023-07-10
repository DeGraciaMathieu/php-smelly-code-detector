<?php

namespace App\Modules\File\Dtos;

class Paths
{
    public function __construct(
        public array $values,
    ) {}

    public static function fromString(string $value): self
    {
        $values = explode(',', $value);

        return new self($values);
    }
}
