<?php

namespace App\Modules\Analyzer\Nodes;

use App\Enums\Visibility;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\FunctionLike;

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

    public static function getName(ClassLike|FunctionLike $node): string
    {
        if ($node->name == null) {
            return 'anonymous';
        }

        return $node->name->name;
    }
}
