<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

use PhpParser\ParserFactory;
use Symfony\Component\Finder\SplFileInfo;

class Detector
{
    public static function parse($file): array
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        $contents = file_get_contents($file->getFullPath());

        return $parser->parse($contents);
    }
}
