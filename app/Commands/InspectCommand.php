<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class InspectCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'inspect {path}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("'inspect' command has been renamed 'inspect-method'");
    }
}
