<?php

namespace App\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use DeGraciaMathieu\FileExplorer\File;

use App\Nodes\ {
	NodeExtractor,
	NodeValidator,
};

use App\Metrics\SmellMetric;

final class ClassVisitor extends NodeVisitorAbstract
{
    public function __construct(
        protected File $file,
        protected array &$bag,
    ) {}

    public function leaveNode(Node $node)
    {
        if (! NodeValidator::isClassOrEquivalent($node)) {
            return;
        }

        $class = [
            'fqcn' => $this->file->displayPath,
            'name' => NodeExtractor::getName($node),
            'type' => NodeExtractor::getClassType($node),
        ];

        foreach ($node->stmts as $stmt) {

            if (! NodeValidator::isMethod($stmt)) {
                continue;
            }

            $method = [
                'name' => NodeExtractor::getName($stmt),
                'constructor' => NodeValidator::methodIsConstructor($node),
                'visibility' => NodeExtractor::getMethodVisibility($node),
                'smell' => SmellMetric::calcul($stmt),
            ] + $class;

            $this->bag[] = $method;
        }
    }
}
