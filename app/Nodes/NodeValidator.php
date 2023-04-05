<?php

namespace App\Nodes;

use PhpParser\Node;
use PhpParser\Node\Stmt;

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

    public static function isMethod(Node $node): bool
    {
        return $node instanceof Stmt\ClassMethod;
    }

    public static function methodIsConstructor(Node $node): bool
    {
        return NodeExtractor::getName($node) === '__construct';
    }
}
