<?php

namespace App\Filters;

use App\Contracts\Filter;

class ThresholdFilter implements Filter
{
    public function reject(array $options, array $item): bool
    {
        if ($this->outsideMinThreshold($options, $item)) {
            return true;
        }

        if ($this->outsideMaxThreshold($options, $item)) {
            return true;
        }

        return false;
    }

    private function outsideMinThreshold(array $options, array $item): bool
    {
        return $options['min-smell'] && $item['smell'] < (int) $options['min-smell'];
    }

    private function outsideMaxThreshold(array $options, array $item): bool
    {
        return $options['max-smell'] && $item['smell'] > (int) $options['max-smell'];
    }
}
