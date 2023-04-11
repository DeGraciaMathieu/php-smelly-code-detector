<?php

namespace App\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use DeGraciaMathieu\FileExplorer\File;
use PhpParser\Node\Stmt\ClassMethod;

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

        $class = $this->extractClassAttributes($node);

        foreach ($node->stmts as $stmt) {

            if (NodeValidator::isMethod($stmt)) {

                $method = $this->extractMethodAttributes($stmt);

                $this->bag[] = $method + $class;
            }
        }

        return null;
    }

    private function extractClassAttributes(Node $node): array
    {
        return [
            'fqcn' => $this->file->displayPath,
            'name' => NodeExtractor::getName($node),
        ];
    }

    protected function extractMethodAttributes(ClassMethod $node): array
    {
        $arguments = count($node->params);
        $ccl = CyclomaticComplexityMetric::calcul($node);
        $loc = LocMetric::calcul($node);

        return [
            'name' => NodeExtractor::getName($node),
            'constructor' => NodeValidator::methodIsConstructor($node),
            'visibility' => NodeExtractor::getMethodVisibility($node),
            'arg' => $arguments,
            'ccl' => $ccl,
            'loc' => $loc,
            'smell' => ($arguments + $ccl) * $loc,
        ];
    }
}
