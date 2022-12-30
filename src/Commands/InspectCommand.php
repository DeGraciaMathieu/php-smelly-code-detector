<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Commands;

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use DeGraciaMathieu\FileExplorer\FileFinder;
use Symfony\Component\Console\Command\Command;
use DeGraciaMathieu\SmellyCodeDetector\Visitors;
use DeGraciaMathieu\SmellyCodeDetector\VisitorBag;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputOption;
use DeGraciaMathieu\SmellyCodeDetector\FileParser;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DeGraciaMathieu\SmellyCodeDetector\Metrics\MethodMetric;
use DeGraciaMathieu\SmellyCodeDetector\Printers\InspectCommandPrinter;

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

        $methods = $this->diveIntoFiles($output, $files);

        $this->showResults($methods, $input, $output);

        return self::SUCCESS;
    }

    protected function getFiles(InputInterface $input)
    {
        $fileFinder = new FileFinder(
            fileExtensions: ['php'], 
            filesToIgnore: [], 
            basePath: __DIR__,
        );

        return $fileFinder->getFiles(paths: [
            $input->getArgument('path'),
        ]);
    }

    protected function diveIntoFiles(OutputInterface $output, iterable $files): iterable
    {
        $fileparser = $this->getFileParser();

        $progressBar = new ProgressBar($output);

        $progressBar->setFormat('verbose');

        foreach ($progressBar->iterate($files) as $file) {

            $visitorBag = new VisitorBag();

            $traverser = new NodeTraverser();

            $traverser->addVisitor(
                new Visitors\CyclomaticComplexityVisitor($visitorBag),
            );

            $traverser->addVisitor(
                new Visitors\ArgumentVisitor($visitorBag),
            );

            $traverser->addVisitor(
                new Visitors\WeightVisitor($visitorBag),
            );

            $tokens = $fileparser->tokenize($file);

            $traverser->traverse($tokens);

            foreach($visitorBag->get() as $name => $metrics)
            {
                yield new MethodMetric(
                    $file->getDisplayPath(), 
                    $name,
                    $metrics,
                );
            }
        }
    }

    protected function getFileParser(): FileParser
    {
        $parserFactory = new ParserFactory();

        $parser = $parserFactory->create(ParserFactory::PREFER_PHP7);

        return new FileParser($parser);
    }

    protected function showResults(iterable $methods, InputInterface $input, OutputInterface $output): void
    {
        $options = $input->getOptions();

        $printer = new InspectCommandPrinter($options);

        $printer->print($output, $methods);
    }
}
