<?php

namespace Tests\Unit\Nodes;

use Tests\TestCase;
use App\Modules\Analyzer\Nodes\NodeValidator;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt;

class NodeValidatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider isAbleToIdentifyClassOrEquivalentProvider
     */
    public function it_able_to_identify_class_or_equivalent($node): void
    {
        $node = new $node('name');

        $isClassOrEquivalent = NodeValidator::isClassOrEquivalent($node);

        $this->assertTrue($isClassOrEquivalent);
    }

    public static function isAbleToIdentifyClassOrEquivalentProvider(): array
    {
        return [
            [Stmt\Class_::class],
            [Stmt\Interface_::class],
            [Stmt\Trait_::class],
        ];
    }

    /**
     * @test
     */
    public function it_able_to_distinguish_a_class_from_something_else(): void
    {
        $node = new ClassMethod('name');

        $isClassOrEquivalent = NodeValidator::isClassOrEquivalent($node);

        $this->assertFalse($isClassOrEquivalent);
    }

    /**
     * @test
     */
    public function it_able_to_identify_constructor(): void
    {
        $node = new ClassMethod('__construct');

        $methodIsConstructor = NodeValidator::methodIsConstructor($node);

        $this->assertTrue($methodIsConstructor);
    }

    /**
     * @test
     */
    public function it_able_to_distinguish_a_constructor_from_something_else(): void
    {
        $node = new ClassMethod('name');

        $methodIsConstructor = NodeValidator::methodIsConstructor($node);

        $this->assertFalse($methodIsConstructor);
    }
}
