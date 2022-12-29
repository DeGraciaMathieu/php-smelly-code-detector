<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PhpParser\Node\Stmt\ClassMethod;
use DeGraciaMathieu\SmellyCodeDetector\VisitorBag;
use DeGraciaMathieu\SmellyCodeDetector\Enums\Metric;

class VisitorBagTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_add_multiple_statements(): void
    {
        $visitorBag = new VisitorBag();

        $foo = new ClassMethod('Foo');
        $bar = new ClassMethod('Bar');

        $visitorBag
            ->add($foo, Metric::Ccn, 1)
            ->add($foo, Metric::Loc, 2)
            ->add($foo, Metric::Arg, 3);

        $visitorBag
            ->add($bar, Metric::Ccn, 4)
            ->add($bar, Metric::Loc, 5);

        $this->assertEquals([
            'Foo' => [
                'Ccn' => 1,
                'Loc' => 2,
                'Arg' => 3,
            ],
            'Bar' => [
                'Ccn' => 4,
                'Loc' => 5,
            ],
        ], $visitorBag->get());
    }
}