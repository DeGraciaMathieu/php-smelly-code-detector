<?php

namespace App\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use DeGraciaMathieu\FileExplorer\File;
use PhpParser\Node\Stmt\ClassMethod;
use App\Wrappers\ClassMethodWrapper;

use App\Nodes\ {
    NodeExtractor,
    NodeValidator,
};

use App\Metrics\ {
    LocMetric,
    CyclomaticComplexityMetric,
};

final class ClassVisitor extends NodeVisitorAbstract
{
    public function __construct(
        protected File $file,
        protected array &$bag,
    ) {}

    public function leaveNode(Node $node)
    {
        if (! NodeValidator::isClassOrEquivalent($node)) {
            return null;
        }

        foreach ($node->stmts as $stmt) {

            if (! NodeValidator::isMethod($stmt)) {
                continue;
            }

            $methodAttributes = $this->extractClassMethodAttributes($stmt);

            $smell = $this->calculSmell($methodAttributes);

            $this->bag[] = [
                'fqcn' => $this->file->displayPath,
                'smell' => $smell,
            ] + $methodAttributes;
        }

        return null;
    }

    private function extractClassMethodAttributes(Node $node): array
    {
        $method = ClassMethodWrapper::from($node);

        return $method->toArray();
    }

    private function calculSmell(array $attributes): int
    {
        return ($attributes['arg'] + $attributes['ccl']) * $attributes['loc'];
    }
}
