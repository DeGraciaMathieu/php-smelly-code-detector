<?php

namespace App\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\ClassMethod;
use App\Wrappers\ClassMethodWrapper;
use DeGraciaMathieu\FileExplorer\File;

final class ClassMethodVisitor extends NodeVisitorAbstract
{
    public function __construct(
        private File $file,
        private array &$methods,
    ) {}

    public function leaveNode(Node $node)
    {
        if ($node instanceof ClassMethod) {

            $attributes = $this->getMethodAttributes($node);

            $this->methods[] = $attributes + [
                'file' => $this->file->displayPath, 
                'smell' => $this->calculSmell($attributes), 
            ];
        }

        return null;
    }

    private function calculSmell(array $attributes): int
    {
        return ($attributes['arg'] + $attributes['ccl']) * $attributes['loc'];
    }

    private function getMethodAttributes(ClassMethod $node): array
    {
        $method = ClassMethodWrapper::from($node);

        return $method->toArray();
    }
}
