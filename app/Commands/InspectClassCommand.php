<?php

namespace App\Commands;

use App\Dtos\ClassSmells;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\View\View as ViewContract;
use LaravelZero\Framework\Commands\Command;

use App\Commands\Traits\ {
    FileFetchingTrait,
    HtmlRenderingTrait,
    MetricsAnalysisTrait,
};

use App\Modules\Render\ {
    RenderService,
    Pipes\SortRows,
    Pipes\CutRows,
};

class InspectClassCommand extends Command
{
    use FileFetchingTrait;
    use MetricsAnalysisTrait;
    use HtmlRenderingTrait;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'inspect-class {path}
        {--only= : Comma-separated list of smells to show.}
        {--ignore= : Comma-separated list of smells to ignore.}
        {--limit=20 : The maximum number of results to show.}
        {--public : Show only public methods.}
        {--private : Show only private methods.}
        {--protected : Show only protected methods.}
        {--without-constructor : Hide constructors.}
        {--sort-by=smell : Sort order (count, smell, avg).}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        $this->info('❀ PHP Smelly Code Detector ❀');

        $files = $this->getAllFiles();

        $metricBag = $this->getMetricsBagFromFiles($files);

        $metrics = $this->analysisMetricsBag($metricBag);

        $rows = $this->prepareMetricsToBeDisplayed($metrics);

        $this->display([
            'displayableRows' => $rows, 
            'numberOfRows' => count($metrics),
        ]);
    }

    private function analysisMetricsBag(array $analysis): array
    {
        $classMetrics = [];

        foreach ($analysis as $className => $methods) {

            $classSmells = $this->getClassSmells($methods);

            $classMetrics[$className] = $classSmells->toArray();
        }

        return $classMetrics;
    }

    private function getClassSmells(array $methods): ClassSmells
    {
        $classSmells = new ClassSmells();

        foreach ($methods as $method) {

            if (! $this->welcomedVisibility($method)) {
                continue;
            }

            if (! $this->welcomedConstructor($method)) {
                continue;
            }

            $classSmells->addMethod($method);
        }

        return $classSmells;
    }

    private function prepareMetricsToBeDisplayed(array $metrics): array
    {
        return app(RenderService::class)->prepareMetricsToBeDisplayed(
            metrics: $metrics,
            filters: [
                new SortRows(
                    sort: $this->option('sort-by'),
                ),
                new CutRows(
                    limit: (int) $this->option('limit'),
                ),
            ]
        );
    }

    private function makeHtml(array $attributes): ViewContract
    {
        return View::make('inspect-class', [
            'displayableRows' => $attributes['displayableRows'],
            'numberOfRows' => $attributes['numberOfRows'],
        ]);
    }
}
