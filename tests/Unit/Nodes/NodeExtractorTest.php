<?php

namespace Tests\Unit\Nodes;

use Tests\TestCase;
use App\Nodes\NodeExtractor;
use PhpParser\Node\Stmt\Class_;

class NodeExtractorTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_retrieve_class_name(): void
    {
        $node = new Class_(
            name: 'Qsdqsdqs',
        );

        $name = NodeExtractor::getName($node);

        $this->assertEquals('Qsdqsdqs', $name);
    }
}
