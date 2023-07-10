<?php

namespace App\Modules\Analyzer\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\ClassMethod;
use App\Modules\Analyzer\Wrappers\ClassMethodWrapper;

class ClassMethodVisitor extends NodeVisitorAbstract
{
    public function __construct(
        private array &$metrics,
    ) {}

    public function leaveNode(Node $node)
    {
        if ($node instanceof ClassMethod) {

            /** @var ClassMethod $node */
            $attributes = $this->getMethodAttributes($node);

            $this->metrics[] = $attributes + [
                'smell' => $this->calculSmell($attributes), 
            ];
        }

        return null;
    }

    private function calculSmell(array $attributes): int
    {
        return ($attributes['arg'] + $attributes['ccn']) * $attributes['loc'];
    }

    private function getMethodAttributes(ClassMethod $node): array
    {
        $method = ClassMethodWrapper::from($node);

        return $method->toArray();
    }
}
