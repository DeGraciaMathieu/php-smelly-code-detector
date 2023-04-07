<?php

namespace App\Pipes;

use Closure;

class CutRows
{
    public function __construct(
        protected int $limit,
    ){}

    public function handle(array $rows, Closure $next)
    {
        if ($this->limit) {
            return array_slice($rows, 0, $this->limit);
        }

        return $next($rows);
    }
}
