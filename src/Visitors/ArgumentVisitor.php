<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Visitors;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use DeGraciaMathieu\SmellyCodeDetector\Enums\Metric;
use DeGraciaMathieu\SmellyCodeDetector\Visitors\Abstracts\Visitor;

class ArgumentVisitor extends Visitor
{
    public array $expectedStatements = [
        Stmt\Class_::class,
        Stmt\Interface_::class,
        Stmt\Trait_::class,
    ];

    protected function diveIntoStatements(Node $node): void
    {
        foreach ($node->stmts as $stmt) {

            if (! $stmt instanceof Stmt\ClassMethod) {
                continue;
            }

            $this->visitorBag->add(
                stmt: $stmt, 
                metric: Metric::Arg,
                value: count($stmt->params),
            );
        }
    }
}
