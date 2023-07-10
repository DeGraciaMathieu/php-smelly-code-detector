<?php

namespace App\Modules\File;

use Generator;
use App\Modules\File\Dtos\Paths;
use App\Modules\File\Dtos\Options;
use DeGraciaMathieu\FileExplorer\FileFinder;

class FileService 
{
    public function all(Paths $paths, Options $options): Generator
    {
        $fileFinder = new FileFinder(
            basePath: getcwd(),
            ignorePatterns: $options->ignore,
            onlyPatterns: $options->only,
        );

        return $fileFinder->getFiles(
            paths: $paths->values,
        );
    }
}
