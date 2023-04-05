<?php

namespace App\Metrics;

use PhpParser\Node;
use PhpParser\Node\Stmt;

class LocMetric
{
    public static function calcul(Node $node): int
    {
        $loc = $node->getEndLine() - $node->getStartLine();

        return $loc;
    }
}
