<?php

namespace App\Commands\Traits;

use Generator;

use App\Modules\File\ {
    FileService,
    Dtos\Paths,
    Dtos\Options,
};

trait FileFetchingTrait
{
    private function getAllFiles(): Generator
    {
        return app(FileService::class)->all(
            Paths::fromString(
                value: $this->argument('path'),
            ),
            Options::fromCommand(
                attributes: $this->options(),
            ),
        );
    }
}
