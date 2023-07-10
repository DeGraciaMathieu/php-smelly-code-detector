<?php

namespace App\Modules\Render;

use Illuminate\Pipeline\Pipeline;

class RenderService
{
    public function prepareMetricsToBeDisplayed(array $metrics, array $filters): array
    {
        return app(Pipeline::class)
            ->send($metrics)
            ->through($filters)
            ->thenReturn();
    }
}
