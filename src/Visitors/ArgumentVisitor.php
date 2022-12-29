<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Visitors;

use Hal\Metric\Helper\MetricClassNameGenerator;
use Hal\Metric\Helper\RoleOfMethodDetector;
use Hal\Metric\Metrics;
use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\NodeVisitorAbstract;
use DeGraciaMathieu\SmellyCodeDetector\Enums\Metric;
use DeGraciaMathieu\SmellyCodeDetector\VisitorBag;

class ArgumentVisitor extends NodeVisitorAbstract
{
    public function __construct(
        protected VisitorBag $visitorBag,
    ) {}

    public function leaveNode(Node $node)
    {
        if ($node instanceof Stmt\Class_
            || $node instanceof Stmt\Interface_
            || $node instanceof Stmt\Trait_
        ) {

            $argByMethod = [];

            foreach ($node->stmts as $stmt) {

                if ($stmt instanceof Stmt\ClassMethod) {

                    $this->visitorBag->add(
                        stmt: $stmt, 
                        metric: Metric::Arg,
                        value: count($stmt->params),
                    );
                }
            }
        }

        return null;
    }
}
