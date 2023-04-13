<?php

namespace Tests\Unit\Visitors;

use Tests\TestCase;
use PhpParser\Parser as PhpParser;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use App\Visitors\ClassMethodVisitor;
use App\Enums\Visibility;
use Illuminate\Testing\Assert;

class ClassMethodVisitorTest extends TestCase
{
    /**
     * @test
     */
    public function it_able_to_traverse_the_nodes(): void
    {
        $methods = $this->analyse(<<<'CODE'
        <?php
        class Bar {
            function Foo($arg)
            {
                if (true) {
                    //
                }
            }
        }
        CODE);

        $this->assertCount(1, $methods);

        $this->assertEquals([
          'name' => 'Foo',
          'constructor' => false,
          'visibility' => Visibility::Public,
          'arg' => 1,
          'ccl' => 2,
          'loc' => 5,
          'smell' => 15,
        ], $methods[0]);
    }

    /**
     * @test
     */
    public function it_able_to_retrieve_many_methods(): void
    {
        $methods = $this->analyse(<<<'CODE'
        <?php
        class Bar {
            private function Foo(){}
            private function Bar(){}
            private function Xyz(){}
        }
        CODE);

        $this->assertCount(3, $methods);
    }

    private function analyse(string $code): array
    {
        $methods = [];

        $nodes = app(PhpParser::class)->parse($code);

        $visitor = new ClassMethodVisitor($methods);

        $this->traverseNodes($nodes, $visitor);

        return $methods;
    }

    private function traverseNodes(array $nodes, ClassMethodVisitor $classMethodVisitor): void
    {
        $traverser = new NodeTraverser();

        $traverser->addVisitor($classMethodVisitor);

        $traverser->traverse($nodes);
    }
}
