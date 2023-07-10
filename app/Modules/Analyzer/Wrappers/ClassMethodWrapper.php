<?php

namespace App\Modules\Analyzer\Wrappers;

use PhpParser\Node\Stmt\ClassMethod;
use App\Enums\Visibility;

use App\Modules\Analyzer\Nodes\ {
    NodeExtractor,
    NodeValidator,
};

use App\Modules\Analyzer\Metrics\ {
    LocMetric,
    CyclomaticComplexityMetric,
};

class ClassMethodWrapper
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

    public function ccn(): int
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
            'ccn' => $this->ccn(),
            'loc' => $this->loc(),
        ];
    }
}
