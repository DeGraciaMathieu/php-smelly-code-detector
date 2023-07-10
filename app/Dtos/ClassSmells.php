<?php

namespace App\Dtos;

use App\Enums\Visibility;

class ClassSmells
{
    public function __construct(
        public int $total = 1,
        public int $count = 1,
        public int $public = 0,
        public int $protected = 0,
        public int $private = 0,
    ){}

    public function addMethod(array $method): void
    {
        $smell = $method['smell'];

        match ($method['visibility']) {
            Visibility::Public => $this->public += $smell,
            Visibility::Private => $this->protected += $smell,
            Visibility::Protected => $this->private += $smell,
        };

        $this->total += $smell;
        $this->count += 1;
    }

    public function toArray(): array
    {
        return [
            'smell' => $this->total,
            'avg' => $this->total / $this->count,
            'count' => $this->count,
            'public' => $this->percent($this->public),
            'protected' => $this->percent($this->protected),
            'private' => $this->percent($this->private),
        ];
    }

    private function percent($value): float
    {
        return ($value * 100) / $this->total;
    }
}
