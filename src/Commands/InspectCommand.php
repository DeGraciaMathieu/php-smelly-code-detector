<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Commands;

use Generator;
use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use DeGraciaMathieu\FileExplorer\FileFinder;
use DeGraciaMathieu\SmellyCodeDetector\Detector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use DeGraciaMathieu\SmellyCodeDetector\FileParser;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DeGraciaMathieu\SmellyCodeDetector\Printers\Console;
use DeGraciaMathieu\SmellyCodeDetector\NodeMethodExplorer;
use DeGraciaMathieu\SmellyCodeDetector\Visitors\FileVisitor;

class InspectCommand extends Command
{
    protected static $defaultName = 'inspect';

    protected function configure($var = null)
    {
        $this->addArgument('path', InputArgument::REQUIRED);

        $this
            ->addOption('min-smell', null, InputOption::VALUE_REQUIRED)
            ->addOption('max-smell', null, InputOption::VALUE_REQUIRED)
            ->addOption('limit', null, InputOption::VALUE_REQUIRED);

        $this
            ->addOption('without-constructor', null, InputOption::VALUE_NONE)
            ->addOption('sort-by-smell', null, InputOption::VALUE_NONE);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('❀ PHP Smelly Code Detector ❀');

        $files = $this->getFiles($input);

        $output->writeln('Scan in progress ...');

        $methods = $this->diveIntoFiles($output, $files);

        $this->showResults($methods, $input, $output);

        return self::SUCCESS;
    }

    protected function getFiles(InputInterface $input)
    {
        $fileFinder = new FileFinder(
            fileExtensions: ['php'], 
            filesToIgnore: [], 
            basePath: __DIR__ . '/../..',
        );

        return $fileFinder->getFiles(paths: [
            $input->getArgument('path'),
        ]);
    }

    protected function diveIntoFiles(OutputInterface $output, Generator $files): iterable
    {
        $fileparser = $this->getFileParser();

        foreach ($files as $file) {

            try {

                $tokens = $fileparser->tokenize($file);

                $fileVisitor = new FileVisitor(
                    new NodeMethodExplorer(
                        filePathName: $file->getDisplayPath(),
                    ),
                );

                $traverser = new NodeTraverser();

                $traverser->addVisitor($fileVisitor);

                $traverser->traverse($tokens);

                foreach ($fileVisitor->getMethods() as $method) {
                    yield $method;
                }

            } catch (Error $e) {
                // See, nobody cares.
            }
        }
    }

    protected function getFileParser(): FileParser
    {
        $parser = (new ParserFactory())
            ->create(ParserFactory::PREFER_PHP7);

        return new FileParser($parser);
    }

    protected function showResults(iterable $methods, InputInterface $input, OutputInterface $output): void
    {
        $options = $input->getOptions([
            'without-constructor',
            'sort-by-smell',
            'min-smell',
            'max-smell',
            'limit',
        ]);

        $printer = new Console($options);

        $printer->print($output, $methods);
    }
}