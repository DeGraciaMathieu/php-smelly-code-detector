<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

use PhpParser\Node\Stmt;
use DeGraciaMathieu\SmellyCodeDetector\Enums\Metric;

class VisitorBag
{
    private array $bag = [];

    public function add(Stmt $stmt, Metric $metric, int $value): VisitorBag
    {
        $name = $stmt->name->name;

        $this->bag[$name][$metric->name] = $value;

        return $this;
    }

    public function get(): array
    {
        return $this->bag;
    }
}
