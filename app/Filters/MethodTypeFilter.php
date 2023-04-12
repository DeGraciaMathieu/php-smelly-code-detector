<?php

namespace App\Filters;

use App\Contracts\Filter;

class MethodTypeFilter implements Filter
{
    public function reject(array $options, array $item): bool
    {
        if ($options['without-constructor'] === null) {
            return false;
        }

        return $item['constructor'];
    }
}
