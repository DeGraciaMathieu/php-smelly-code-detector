<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

use PhpParser\Node\Stmt\ClassMethod;
use DeGraciaMathieu\SmellyCodeDetector\Enums\Metric;

class VisitorBag
{
    private array $bag = [];

    public function addClassMethod(ClassMethod $classMethod, Metric $metric, int $value): VisitorBag
    {
        $name = $classMethod->name->name;

        $this->bag[$name][$metric->name] = $value;

        return $this;
    }

    public function get(): array
    {
        return $this->bag;
    }
}
