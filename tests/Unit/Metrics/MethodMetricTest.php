<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Tests\Unit\Metrics;

use PHPUnit\Framework\TestCase;
use DeGraciaMathieu\SmellyCodeDetector\Metrics\MethodMetric;

class MethodMetricTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_file()
    {
        $methodMetric = $this->getMethodMetricInstance();

        $this->assertEquals('Foo.php', $methodMetric->getFile());
    }

    /**
     * @test
     */
    public function it_can_get_name()
    {
        $methodMetric = $this->getMethodMetricInstance();

        $this->assertEquals('Foo', $methodMetric->getName());
    }

    /**
     * @test
     * @dataProvider canDetectedConstructorMethodProvider
     */
    public function it_can_detect_constructor_method(bool $expected, string $name)
    {
        $methodMetric =  new MethodMetric(
            file: 'Foo.php',
            name: $name,
            metrics: [],
        );

        $this->assertEquals($expected, $methodMetric->isConstructor());
    }

    /**
     * @test
     */
    public function it_can_calcul_smell()
    {
        $methodMetric = $this->getMethodMetricInstance();

        $this->assertEquals(8, $methodMetric->getSmell());
    }

    public function canDetectedConstructorMethodProvider(): array
    {
        return [
            [true, '__construct'],
            [false, 'construct'],
            [false, 'handle'],
        ];
    }

    private function getMethodMetricInstance(): MethodMetric
    {
        return new MethodMetric(
            file: 'Foo.php',
            name: 'Foo',
            metrics: [
                'Ccn' => 1,
                'Loc' => 2,
                'Arg' => 3,
            ],
        );
    }
}
