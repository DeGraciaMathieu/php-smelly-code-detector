<?php

namespace App\Filters;

use Generator;

class FilterAggregator
{
    private array $filters = [];

    public function __construct(
        private array $options,
    ){}

    public function add(array $filters): void
    {
        $this->filters = $filters;
    }

    public function applyOn(Generator $items): array
    {
        $rows = [];

        foreach ($items as $item) {

            if ($this->passes($item)) {
                $rows[] = $item;
            }
        }

        return $rows;
    }

    private function passes(array $item): bool
    {
        foreach ($this->filters as $filter) {

            $rejected = $filter->reject(
                $this->options, 
                $item,
            );

            if ($rejected) {
                return false;
            }
        }

        return true;
    }
}
