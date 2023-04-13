<?php

namespace Tests\Unit\Wrappers;

use Tests\TestCase;
use PhpParser\Node\Stmt\ClassMethod;
use App\Wrappers\ClassMethodWrapper;
use Illuminate\Testing\Assert;
use App\Enums\Visibility;

class ClassMethodWrapperTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_able_to_initialize_a_new_instance(): void
    {
        $node = new ClassMethod(
            name: 'Qsdqsdqs',
        );

        $classMethodWrapper = ClassMethodWrapper::from($node);

        $this->assertInstanceOf(ClassMethodWrapper::class, $classMethodWrapper);
    }

       /**
     * @test
     */
    public function it_can_summarize(): void
    {
        $node = new ClassMethod(
            name: 'Qsdqsdqs',
        );

        $classMethodWrapper = new ClassMethodWrapper($node);

        $attributes = $classMethodWrapper->toArray();

        Assert::assertArraySubset([
          'name' => 'Qsdqsdqs',
          'constructor' => false,
          'visibility' => Visibility::Public,
          'arg' => 0,
          'ccl' => 1,
          'loc' => 0,
        ], $attributes);
    }
}
