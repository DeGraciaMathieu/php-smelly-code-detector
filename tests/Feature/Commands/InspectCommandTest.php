<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;

class InspectCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_analyse_folder(): void
    {
        $this->artisan('inspect ' . __DIR__ . '/')
            ->expectsOutput('❀ PHP Smelly Code Detector ❀')
            ->assertSuccessful();
    }
}
