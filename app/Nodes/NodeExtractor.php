<?php

namespace App\Nodes;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use App\Enums\Visibility;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Class_;

class NodeExtractor
{
    public static function getMethodVisibility(ClassMethod $node): Visibility
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

    public static function getName(ClassMethod|Class_ $node): string
    {
        if ($node->name == null) {
            return 'anonymous';
        }

        return $node->name->name;
    }
}
