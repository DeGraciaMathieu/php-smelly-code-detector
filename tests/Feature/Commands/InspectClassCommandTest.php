<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;

class InspectClassCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_analyse_folder(): void
    {
        $this->artisan('inspect-class ' . __DIR__ . '/')
            ->expectsOutput('❀ PHP Smelly Code Detector ❀')
            ->assertSuccessful();
    }
}
