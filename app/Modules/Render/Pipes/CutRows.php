<?php

namespace App\Modules\Render\Pipes;

use Closure;

class CutRows
{
    public function __construct(
        protected int $limit,
    ){}

    public function handle(array $rows, Closure $next): array
    {
        if ($this->limit) {
            $rows = array_slice($rows, 0, $this->limit);
        }

        return $next($rows);
    }
}
