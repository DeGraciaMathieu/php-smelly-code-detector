<?php

namespace App\Modules\Render;

use App\Modules\Render\Dtos\Option;
use App\Modules\Render\Contracts\Renderer;
use App\Modules\Render\Renderers\JsonRenderer;
use App\Modules\Render\Renderers\ViewRenderer;

class RendererFactory
{
    private array $renderers = [
        'json' => JsonRenderer::class,
        'view' => ViewRenderer::class,
    ];

    public function from(Option $option): Renderer
    {
        $renderer = $this->renderers[$option->type->value];

        return app($renderer);
    }
}
