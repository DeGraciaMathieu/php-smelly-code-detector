<?php

namespace App\Modules\Analyzer\Metrics;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use App\Modules\Analyzer\Contracts\Metric;
use PhpParser\Node\Stmt\ClassMethod;

class CyclomaticComplexityMetric implements Metric
{
    public static function calcul(ClassMethod $node): int
    {
        // iterate over children, recursively
        $cb = function ($node) use (&$cb) {

            $ccn = 0;

            foreach (get_object_vars($node) as $name => $member) {
                foreach (is_array($member) ? $member : [$member] as $memberItem) {
                    if ($memberItem instanceof Node) {
                        $ccn += $cb($memberItem);
                    }
                }
            }

            switch (true) {
                case $node instanceof Stmt\If_:
                case $node instanceof Stmt\ElseIf_:
                case $node instanceof Stmt\For_:
                case $node instanceof Stmt\Foreach_:
                case $node instanceof Stmt\While_:
                case $node instanceof Stmt\Do_:
                case $node instanceof Node\Expr\BinaryOp\LogicalAnd:
                case $node instanceof Node\Expr\BinaryOp\LogicalOr:
                case $node instanceof Node\Expr\BinaryOp\LogicalXor:
                case $node instanceof Node\Expr\BinaryOp\BooleanAnd:
                case $node instanceof Node\Expr\BinaryOp\BooleanOr:
                case $node instanceof Stmt\Catch_:
                case $node instanceof Node\Expr\Ternary:
                case $node instanceof Node\Expr\BinaryOp\Coalesce:
                    $ccn++;
                    break;
                case $node instanceof Stmt\Case_:
                    if ($node->cond !== null) { // exclude default
                        $ccn++;
                    }
                    break;
                case $node instanceof Node\Expr\BinaryOp\Spaceship:
                    $ccn += 2;
                    break;
            }
            return $ccn;
        };

        $methodCcn = $cb($node) + 1; // each method by default is CCN 1 even if it's empty

        return $methodCcn;
    }
}
