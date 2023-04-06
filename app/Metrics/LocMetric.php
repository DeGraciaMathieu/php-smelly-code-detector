<?php

namespace App\Metrics;

use PhpParser\Node;
use App\Contracts\Metric;

class LocMetric implements Metric
{
    public static function calcul(Node $node): int
    {
        $loc = $node->getEndLine() - $node->getStartLine();

        return $loc;
    }
}
