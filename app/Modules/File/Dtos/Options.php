<?php

namespace App\Modules\File\Dtos;

class Options
{
    public function __construct(
        public array $ignore,
        public array $only,
    ) {}

    public static function fromCommand(array $attributes): self
    {
        if ($ignore = $attributes['ignore']) {
            $ignorePatterns = explode(',', $ignore);
        }

        if ($only = $attributes['only']) {
            $onlyPatterns = explode(',', $only);
        }

        return new self(
            ignore: $ignorePatterns ?? [],
            only: $onlyPatterns ?? [],
        );
    }
}
