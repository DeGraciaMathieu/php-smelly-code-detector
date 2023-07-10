<?php

namespace App\Modules\Analyzer\Nodes;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;

final class NodeValidator
{
    public static function isClassOrEquivalent(Node $node): bool
    {
        $expected = [
            Stmt\Class_::class,
            Stmt\Interface_::class,
            Stmt\Trait_::class,
        ];

        return in_array($node::class, $expected, true);
    }

    public static function methodIsConstructor(ClassMethod $node): bool
    {
        return NodeExtractor::getName($node) === '__construct';
    }
}
