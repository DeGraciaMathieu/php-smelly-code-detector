<?php

namespace Tests\Unit\Render;

use Tests\TestCase;
use App\Modules\Render\RendererFactory;
use App\Modules\Render\Dtos\Option;
use App\Modules\Render\Renderers\JsonRenderer;
use App\Modules\Render\Renderers\ViewRenderer;

class RendererFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_able_to_instantiate_json_renderer(): void
    {
        $factory = new RendererFactory();

        $renderer = $factory->from(
            Option::fromCommand(attributes: [
                'json' => true,
            ]),
        );

        $this->assertInstanceOf(JsonRenderer::class, $renderer);
    }

    /**
     * @test
     */
    public function it_able_to_instantiate_view_renderer(): void
    {
        $factory = new RendererFactory();

        $renderer = $factory->from(
            Option::fromCommand(attributes: [
                'json' => false,
            ]),
        );

        $this->assertInstanceOf(ViewRenderer::class, $renderer);
    }
}
