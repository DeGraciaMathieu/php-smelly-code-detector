<?php

namespace Tests\Unit\Nodes;

use Tests\TestCase;
use App\Nodes\NodeExtractor;
use PhpParser\Node\Stmt\Class_;
use App\Enums\Visibility;
use PhpParser\Node\Stmt\ClassMethod;

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

    /**
     * @test
     */
    public function it_can_retrieve_anonymous_class_name(): void
    {
        $node = new Class_(
            name: null,
        );

        $name = NodeExtractor::getName($node);

        $this->assertEquals('anonymous', $name);
    }

    /**
     * @test
     * @dataProvider itCanRetrieveMethodVisibilityProvider
     */
    public function it_can_retrieve_method_visibility(int $visibilityFlag, Visibility $expected): void
    {
        $node = new ClassMethod(
            name: 'name',
            subNodes: [
                'flags' => $visibilityFlag,
            ],
        );

        $visibility = NodeExtractor::getMethodVisibility($node);

        $this->assertEquals($visibility, $expected);
    }

    public static function itCanRetrieveMethodVisibilityProvider(): array
    {
        return [
            [Class_::MODIFIER_PUBLIC, Visibility::Public],
            [Class_::MODIFIER_PROTECTED, Visibility::Protected],
            [Class_::MODIFIER_PRIVATE, Visibility::Private],
        ];
    }
}
