<?php

namespace App\Filters;

use App\Contracts\Filter;
use App\Enums\Visibility;

class MethodVisibilityFilter implements Filter
{
    public function reject(array $options, array $item): bool
    {
        if ($this->keepAllVisibilities($options)) {
            return false;
        }

        return ! match ($item['visibility']) {
            Visibility::Public => $options['public'],
            Visibility::Private => $options['private'],
            Visibility::Protected => $options['protected'],
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
