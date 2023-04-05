<?php

namespace App\Nodes;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use App\Enums\Visibility;

class NodeExtractor
{
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
