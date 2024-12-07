<?php

namespace App\Modules\Render\Renderers;

use App\Modules\Render\Contracts\Renderer;
use Termwind\HtmlRenderer;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Factory as ViewFactory;

class ViewRenderer implements Renderer
{
    public function __construct(
        private ViewFactory $view,
        private HtmlRenderer $htmlRenderer,
    ) {}

    public function display(string $view, array $attributes): void
    {
        $html = $this->makeHtml($view, $attributes);

        $this->renderHtml($html);
    }

    protected function makeHtml(string $view, array $attributes): ViewContract
    {
        return $this->view->make($view, $attributes);
    }

    private function renderHtml(ViewContract $html): void
    {
        $this->htmlRenderer->render($html, OutputInterface::OUTPUT_NORMAL);
    }
}
