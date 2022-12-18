<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

use PhpParser\ParserFactory;
use Symfony\Component\Finder\SplFileInfo;

class Detector
{
    public static function parse(SplFileInfo $file): array
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        $contents = $file->getContents();

        return $parser->parse($contents);
    }
}
