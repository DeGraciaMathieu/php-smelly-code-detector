<?php

namespace App\Commands;

use Generator;
use LaravelZero\Framework\Commands\Command;
use function Termwind\{render};
use App\Factories\FileFinderFactory;
use Illuminate\Pipeline\Pipeline;
use App\Visitors\ClassVisitor;

use PhpParser\ {
    Parser,
    NodeTraverser,
};

use App\Filters\ {
    FilterAggregator,
    MethodVisibilityFilter,
    MethodTypeFilter,
    ThresholdFilter,
};

use App\Pipes\ {
    SortRows,
    CutRows,
};

class InspectCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'inspect {path}
        {--min-smell= : The minimum smell threshold to show.}
        {--max-smell= : The maximum smell threshold to show.}
        {--only= : Comma-separated list of smells to show.}
        {--ignore= : Comma-separated list of smells to ignore.}
        {--limit= : The maximum number of results to show.}
        {--public : Show only public methods.}
        {--private : Show only private methods.}
        {--protected : Show only protected methods.}
        {--without-constructor : Hide constructors.}';

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
        $this->info('❀ PHP Smelly Code Detector ❀');

        $files = $this->getFilesFromPath();

        $metrics = $this->analyseFiles($files);

        $rows = $this->applyFiltersOnMetrics($metrics);

        $rows = $this->prepareRowsToBeDisplayed($rows);

        render(view('inspect', [
            'rows' => $rows,
        ]));
    }

    private function getFilesFromPath(): Generator
    {
        $fileFinder = FileFinderFactory::fromOptions(
            basePath: getcwd(),
            options: $this->options(),
        );

        $path = $this->argument('path');

        return $fileFinder->getFiles(
            paths: explode(',', $path),
        );
    }

    private function analyseFiles(Generator $files): iterable
    {
        foreach ($files as $file) {

            $methods = [];

            $traverser = new NodeTraverser();

            $visitor = new ClassVisitor($file, $methods);

            $traverser->addVisitor($visitor);

            $contents = $file->contents();

            $nodes = app(Parser::class)->parse($contents);

            $traverser->traverse($nodes);

            foreach ($methods as $method) {
                yield $method;
            }
        }
    }

    private function applyFiltersOnMetrics(Generator $methods)
    {
        $filter = new FilterAggregator(
            options: $this->options(),
        );

        $filter->add([
            new MethodVisibilityFilter(),
            new MethodTypeFilter(),
            new ThresholdFilter(),
        ]);

        $rows = $filter->applyOn($methods);

        return $rows;
    }

    private function prepareRowsToBeDisplayed(array $rows): array
    {
        $rows = app(Pipeline::class)
            ->send($rows)
            ->through([
                new SortRows(),
                new CutRows(
                    limit: (int) $this->option('limit'),
                ),
            ])
            ->thenReturn();

        return $rows;
    }
}
