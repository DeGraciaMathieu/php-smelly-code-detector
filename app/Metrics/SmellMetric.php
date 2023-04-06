<?php

namespace App\Metrics;

use PhpParser\Node;
use App\Contracts\Metric;

class SmellMetric implements Metric
{
    public static function calcul(Node $node): int
    {
        $arguments = count($node->params);

        $ccl = CyclomaticComplexityMetric::calcul($node);
        
        $loc = LocMetric::calcul($node);

        return ($arguments + $ccl) * $loc;
    }
}
