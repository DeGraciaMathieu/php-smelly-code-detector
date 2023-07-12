<?php

namespace App\Modules\Render\Renderers;

use App\Modules\Render\Contracts\Renderer;

class JsonRenderer implements Renderer
{
    public function display(string $view, array $attributes): void
    {
        echo json_encode($attributes);
    }
}
