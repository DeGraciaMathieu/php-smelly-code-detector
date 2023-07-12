<?php

namespace App\Commands;

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

class InspectMethodCommand extends Command
{
    use FileFetchingTrait;
    use MetricsAnalysisTrait;
    use HtmlRenderingTrait;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'inspect-method {path}
        {--min-smell= : The minimum smell threshold to show.}
        {--max-smell= : The maximum smell threshold to show.}
        {--only= : Comma-separated list of smells to show.}
        {--ignore= : Comma-separated list of smells to ignore.}
        {--limit=20 : The maximum number of results to show.}
        {--public : Show only public methods.}
        {--private : Show only private methods.}
        {--protected : Show only protected methods.}
        {--without-constructor : Hide constructors.}
        {--sort-by=smell : Sort order (smell, loc, arg, ccl).}
        {--json : Render metrics in JSON.}
        ';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->hello();

        $files = $this->getAllFiles();

        $metricBag = $this->getMetricsBagFromFiles($files);

        $metrics = $this->analysisMetricsBag($metricBag);

        $rows = $this->prepareMetricsToBeDisplayed($metrics);

        $this->display($rows, $metrics);
    }

    private function analysisMetricsBag(array $analysis): array
    {
        $methodMetrics = [];

        foreach ($analysis as $className => $methods) {

            foreach ($methods as $method) {

                if (! $this->welcomedVisibility($method)) {
                    continue;
                }

                if (! $this->welcomedConstructor($method)) {
                    continue;
                }

                if (! $this->welcomedThreshold($method)) {
                    continue;
                }

                $methodMetrics[] = [
                    'class' => $className,
                    'method' => $method['name'],
                    'visibility' => $method['visibility'],
                    'loc' => $method['loc'],
                    'ccn' => $method['ccn'],
                    'arg' => $method['arg'],
                    'smell' => $method['smell'],
                ];
            }
        }

        return $methodMetrics;
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

    private function display(array $rows, array $metrics): void
    {
        $renderer = $this->makeRendererInstance();

        $renderer->display(
            view: 'inspect-method',
            attributes: [
                'displayableRows' => $rows, 
                'numberOfRows' => count($metrics),
            ],
        );
    }
}
