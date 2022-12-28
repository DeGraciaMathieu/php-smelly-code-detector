<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Metrics;

use DeGraciaMathieu\SmellyCodeDetector\Enums\Metric;

class MethodMetric
{
    public function __construct(
        private readonly string $file,
        private readonly string $name,
    	private readonly array $metrics,
    ) {}

    public function getFile(): string
    {
        return $this->file;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isConstructor(): bool
    {
        return $this->name === '__construct';
    }

    public function getLoc(): int
    {
        $name = Metric::Loc->name;

        return $this->metrics[$name] ?? 1;
    }

    public function getArg(): int
    {
        $name = Metric::Arg->name;

        return $this->metrics[$name] ?? 0;
    }

    public function getCcn(): int
    {
        $name = Metric::Ccn->name;

        return $this->metrics[$name] ?? 1;
    }

    public function getSmell(): int
    {
        $loc = $this->getLoc();
        $ccn = $this->getCcn();
        $arg = $this->getArg();

        return ($ccn + $arg) * $loc;
    }
}
