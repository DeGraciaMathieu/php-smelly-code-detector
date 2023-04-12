<?php

namespace App\Wrappers;

use PhpParser\Node\Stmt\ClassMethod;
use App\Enums\Visibility;

use App\Nodes\ {
    NodeExtractor,
    NodeValidator,
};

use App\Metrics\ {
    LocMetric,
    CyclomaticComplexityMetric,
};

final class ClassMethodWrapper
{
    public function __construct(
        private ClassMethod $node,
    ){}

    public static function from(ClassMethod $node): self
    {
        return new self($node);
    }

    public function name(): string
    {
        return NodeExtractor::getName($this->node);
    }

    public function isConstructor(): bool
    {
        return NodeValidator::methodIsConstructor($this->node);
    }

    public function visibility(): Visibility
    {
        return NodeExtractor::getMethodVisibility($this->node);
    }

    public function arguments(): int
    {
        return count($this->node->params);
    }

    public function ccl(): int
    {
        return CyclomaticComplexityMetric::calcul($this->node);
    }

    public function loc(): int
    {
        return LocMetric::calcul($this->node);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'constructor' => $this->isConstructor(),
            'visibility' => $this->visibility(),
            'arg' => $this->arguments(),
            'ccl' => $this->ccl(),
            'loc' => $this->loc(),
        ];
    }
}
