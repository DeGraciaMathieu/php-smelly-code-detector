<?php

namespace App\Modules\Render\Contracts;

interface Renderer
{
    public function display(string $view, array $attributes): void;
}
