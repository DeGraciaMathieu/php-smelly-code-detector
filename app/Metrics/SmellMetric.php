<?php

namespace App\Metrics;

use PhpParser\Node;
use App\Contracts\Metric;
use PhpParser\Node\Stmt\ClassMethod;

class SmellMetric implements Metric
{
    public static function calcul(ClassMethod $node): int
    {
        $arguments = count($node->params);

        $ccl = CyclomaticComplexityMetric::calcul($node);
        
        $loc = LocMetric::calcul($node);

        return ($arguments + $ccl) * $loc;
    }
}
