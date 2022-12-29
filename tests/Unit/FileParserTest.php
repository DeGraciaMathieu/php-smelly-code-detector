<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Tests\Unit;

use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;
use DeGraciaMathieu\FileExplorer\File;
use DeGraciaMathieu\SmellyCodeDetector\FileParser;

class FileParserTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_parse_class(): void
    {
        $parser = (new ParserFactory())
            ->create(ParserFactory::PREFER_PHP7);

        $fileParser = new FileParser($parser);

        $file = new File(
            fullPath: __DIR__ . '/Stubs/Foo.php',
            displayPath: 'Stubs/Foo',
        );

        $tokens = $fileParser->tokenize($file);

        $this->assertIsArray($tokens);
    }
}
