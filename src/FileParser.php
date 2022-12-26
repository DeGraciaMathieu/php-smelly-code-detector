<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

use PhpParser\Parser;
use DeGraciaMathieu\FileExplorer\File;

class FileParser
{
    public function __construct(
        private Parser $parser,
    ) {}

    public function tokenize(File $file): array
    {
        $contents = $this->getFileContent($file);

        return $this->parser->parse($contents);
    }

    protected function getFileContent(File $file): string
    {
        $fullPath = $file->getFullPath();

        return file_get_contents($fullPath);
    }
}
