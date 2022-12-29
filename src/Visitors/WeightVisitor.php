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

class WeightVisitor extends NodeVisitorAbstract
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

            $weightByMethod = [];

            foreach ($node->stmts as $stmt) {

                if (! $stmt instanceof Stmt\ClassMethod) {
                    continue;
                }

                $loc = $this->getLoc($stmt);

                $this->visitorBag->add(
                    stmt: $stmt, 
                    metric: Metric::Loc,
                    value: $loc,
                );
            }
        }

        return null;
    }

    protected function getLoc(Node $node): int
    {
        return $node->getEndLine() - $node->getStartLine();
    }
}
