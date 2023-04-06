<?php

namespace App\Contracts;

interface Filter
{
    public function reject(array $options, array $item): bool;
}
