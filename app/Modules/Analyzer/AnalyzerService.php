<?php

namespace App\Modules\Analyzer;

use PhpParser\Parser as PhpParser;
use PhpParser\NodeTraverser;

class AnalyzerService
{
    public function __construct(
        private PhpParser $phpParser,
    ) {}

    public function getMetricsBagFromFiles($files, array $visitors): array
    {
        $metricsBag = [];

        foreach ($files as $file) {

            $metrics = [];

            $traverser = $this->instantiateTraverser($visitors, $metrics);

            $nodes = $this->phpParser->parse(
                code: $file->contents(),
            );

            $traverser->traverse($nodes);

            $metricsBag[$file->displayPath] = $metrics;
        }

        return $metricsBag;
    }

    private function instantiateTraverser(array $visitors, &$metrics): NodeTraverser
    {
        $traverser = new NodeTraverser();

        foreach ($visitors as $visitor) {

            $visitor = new $visitor($metrics);

            $traverser->addVisitor($visitor);
        }

        return $traverser;
    }
}
