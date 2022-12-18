<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\ClassMethod;
use DeGraciaMathieu\SmellyCodeDetector\NodeMethodExplorer;

class FileVisitor extends NodeVisitorAbstract
{
    protected $methods = [];

    public function __construct(
        protected NodeMethodExplorer $nodeMethodExplorer,
    ) {}

    public function beforeTraverse(array $nodes): void
    {
        $this->methods = [];
    }

    public function leaveNode(Node $node): void
    {
        if ($node instanceof ClassMethod) {
            $this->methods[] = $this->nodeMethodExplorer->get($node);
        }
    }

    public function getMethods(): iterable
    {
        foreach ($this->methods as $method) {
            yield from $method;
        }
    }
}
