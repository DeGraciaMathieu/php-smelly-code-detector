<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

use PhpParser\ParserFactory;

class Detector
{
    public static function parse(string $file): array
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        $buffer = file_get_contents($file);

        return $parser->parse($buffer);
    }
}
