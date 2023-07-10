<?php

namespace App\Commands\Traits;

use Termwind\HtmlRenderer;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Contracts\View\View as ViewContract;

trait HtmlRenderingTrait
{
    abstract protected function makeHtml(array $attributes): ViewContract;

    protected function display(array $attributes): void
    {
        $html = $this->makeHtml($attributes);

        $this->renderHtml($html);
    }

    private function renderHtml($html): void
    {
        $htmlRenderer = new HtmlRenderer();

        $htmlRenderer->render($html, OutputInterface::OUTPUT_NORMAL);
    }
}
