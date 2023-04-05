<?php

namespace App\Pipes;

use Closure;

class SortRows
{
    public function handle(array $rows, Closure $next)
    {
        uasort($rows, function ($a, $b) {

            if ($a['smell'] == $b['smell']) {
                return 0;
            }

            return ($a['smell'] < $b['smell']) ? 1 : -1;
        });

        return $next($rows);
    }
}
