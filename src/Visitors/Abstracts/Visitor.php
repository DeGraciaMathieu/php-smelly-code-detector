<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Visitors\Abstracts;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use DeGraciaMathieu\SmellyCodeDetector\VisitorBag;

abstract class Visitor extends NodeVisitorAbstract
{
    public array $expectedStatements = [];

    public function __construct(
        protected VisitorBag $visitorBag,
    ) {}

    public function leaveNode(Node $node)
    {
        if ($this->unexpectedStatement($node)) {
            return null;
        }

        $this->diveIntoStatements($node);

        return null;
    }

    protected function unexpectedStatement(Node $node): bool
    {
        return ! in_array($node::class, $this->expectedStatements, true);
    }

    protected abstract function diveIntoStatements(Node $node): void;
}
