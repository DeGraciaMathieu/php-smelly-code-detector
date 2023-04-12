<?php

namespace App\Factories;

use DeGraciaMathieu\FileExplorer\FileFinder;

class FileFinderFactory
{
    public static function fromOptions(string $basePath, array $options): FileFinder
    {
        if ($ignore = $options['ignore']) {
            $ignorePatterns = explode(',', $ignore);
        }

        if ($only = $options['only']) {
            $onlyPatterns = explode(',', $only);
        }

        return new FileFinder(
            basePath: $basePath, 
            ignorePatterns: $ignorePatterns ?? [],
            onlyPatterns: $onlyPatterns ?? [],
        );
    }
}
