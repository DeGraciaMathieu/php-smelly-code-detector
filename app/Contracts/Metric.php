<?php

namespace App\Contracts;

use PhpParser\Node;

interface Metric
{
    public static function calcul(Node $node): int;
}
