<?php

namespace App\Contracts;

use App\Contracts\Filter;

interface Filter
{
    public function reject(array $options, array $item): bool;
}
