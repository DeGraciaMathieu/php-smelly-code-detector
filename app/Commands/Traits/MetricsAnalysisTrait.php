<?php

namespace App\Commands\Traits;

use Generator;

use App\Modules\Analyzer\ {
    AnalyzerService,
    Visitors\ClassMethodVisitor,
};

use App\Modules\Filter\ {
    WelcomedThreshold,
    WelcomedVisibility,
    WelcomedConstructor,
    Dtos\Visibilities,
    Dtos\Thresholds,
};

trait MetricsAnalysisTrait
{
    private function getMetricsBagFromFiles(Generator $files): array
    {
        return app(AnalyzerService::class)->getMetricsBagFromFiles(
            files: $files,
            visitors: [
                ClassMethodVisitor::class,
            ],
        );
    }

    private function welcomedVisibility(array $method): bool
    {   
        return WelcomedVisibility::passes(
            $method,
            Visibilities::fromCommand(
                attributes: $this->options(),
            ),
        );
    }

    private function welcomedConstructor(array $method): bool
    {
        return WelcomedConstructor::passes(
            method: $method,
            withoutConstructor: $this->option('without-constructor'),
        );
    }

    private function welcomedThreshold(array $method): bool
    {
        return WelcomedThreshold::passes(
            $method,
            Thresholds::fromCommand(
                attributes: $this->options(),
            ),
        );
    }
}
