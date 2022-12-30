<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Tests\Unit\Commands;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use DeGraciaMathieu\SmellyCodeDetector\Commands\InspectCommand;

class InspectCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_launch_inspect_command(): void
    {
    	$command = new InspectCommand();

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'path' => __DIR__ . '/../Stubs/',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();

        $assertStringContainsString = function ($expected) use ($output) {
        	$this->assertStringContainsString($expected, $output);
        };

        $assertStringContainsString('❀ PHP Smelly Code Detector ❀');
        $assertStringContainsString('bar');
        $assertStringContainsString('baz');
        $assertStringContainsString('15');
        $assertStringContainsString('50');
        $assertStringContainsString('2 methods found.');
    }
}