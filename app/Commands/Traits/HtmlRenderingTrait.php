<?php

namespace App\Commands\Traits;

use App\Modules\Render\RendererFactory;
use App\Modules\Render\Dtos\Option;
use App\Modules\Render\Contracts\Renderer;

trait HtmlRenderingTrait
{
    abstract private function display(array $rows, array $metrics): void;

    protected function hello()
    {
        /**
         * In the case of rendering in JSON, 
         * the prompt should not be polluted
         */
        $mustSayHello = ! $this->option('json');

        if ($mustSayHello) {
            $this->info('❀ PHP Smelly Code Detector ❀');
        }
    }

    protected function makeRendererInstance(): Renderer
    {
        return app(RendererFactory::class)->from(
            Option::fromCommand($this->options()),
        );
    }
}
