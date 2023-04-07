<?php

namespace App\Metrics;

use App\Contracts\Metric;
use PhpParser\Node\Stmt\ClassMethod;

class LocMetric implements Metric
{
    public static function calcul(ClassMethod $node): int
    {
        $loc = $node->getEndLine() - $node->getStartLine();

        return $loc;
    }
}
