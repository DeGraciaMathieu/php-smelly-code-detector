<?php

namespace App\Modules\Filter\Dtos;

class Visibilities
{
    public function __construct(
        public bool $public,
        public bool $protected,
        public bool $private,
    ) {}

    public static function fromCommand(array $attributes): self
    {
        return new self(
            public: $attributes['public'],
            protected: $attributes['protected'],
            private: $attributes['private'],
        );
    }
}
