<?php

namespace App\Pipes;

use Closure;

class SortRows
{
    public function __construct(
        protected string $sort,
    ){}

    public function handle(array $rows, Closure $next): array
    {
        uasort($rows, function ($a, $b) {

            if ($a[$this->sort] == $b[$this->sort]) {
                return 0;
            }

            return ($a[$this->sort] < $b[$this->sort]) ? 1 : -1;
        });

        return $next($rows);
    }
}
