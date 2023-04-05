<?php

namespace App\Nodes;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use App\Enums\Visibility;

class NodeExtractor
{
    public static function getClassType(Node $node): string
    {
        return match (true) {
            $node instanceof Stmt\Class_ => 'class',
            $node instanceof Stmt\Interface_ => 'interface',
            $node instanceof Stmt\Trait_ => 'trait',
            default => 'unknown',
        };
    }

    public static function getMethodVisibility(Node $node): Visibility
    {
        if ($node->isPublic()) {
            return Visibility::Public;
        }

        if ($node->isProtected()) {
            return Visibility::Protected;
        }

        if ($node->isPrivate()) {
            return Visibility::Private;
        }

        throw new \RuntimeException('Unexpected visibility.');
    }

    public static function getName(Node $node): string
    {
        if ($node->name == null) {
            return 'anonymous';
        }

        return $node->name->name;
    }
}
