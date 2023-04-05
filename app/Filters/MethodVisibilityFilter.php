<?php

namespace App\Filters;

use App\Contracts\Filter;

class MethodVisibilityFilter implements Filter
{
    public function reject(array $options, array $item): bool
    {
        if ($this->keepAllVisibilities($options)) {
            return false;
        }

        return ! match ($item['visibility']) {
            'public' => $options['public'],
            'private' => $options['private'],
            'protected' => $options['protected'],
        };
    }

    private function keepAllVisibilities(array $options): bool
    {
        return ! in_array(true, [
            $options['public'],
            $options['private'],
            $options['protected'],
        ], true);
    }
}
