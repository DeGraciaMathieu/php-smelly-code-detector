<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Commands;

use PhpParser\Error;
use PhpParser\NodeTraverser;
use Symfony\Component\Finder\Finder;
use DeGraciaMathieu\SmellyCodeDetector\Detector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\ProgressBar;
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

        $finder = $this->createFinder($input);

        if (! $finder->hasResults()) {

            $output->writeln('No files found to scan');

            return self::SUCCESS;
        }

        $methods = $this->diveIntoNodes($output, $finder);

        $this->showResults($methods, $input, $output);

        return self::SUCCESS;
    }

    protected function createFinder(InputInterface $input): Finder
    {
        $path = $input->getArgument('path');

        $finder = Finder::create()
            ->files()
            ->name('*.php')
            ->in($path);

        return $finder;
    }

    protected function diveIntoNodes(OutputInterface $output, Finder $finder): iterable
    {
        $progressBar = $this->startProgressBar($output, $finder);

        $detector = new Detector();

        foreach ($finder as $file) {

            try {

                $tokens = Detector::parse($file);

                $fileVisitor = new FileVisitor(
                    new NodeMethodExplorer(
                        filePathName: $file->getPathname(),
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

            $progressBar->advance();
        }

        $progressBar->finish();
    }

    protected function startProgressBar(OutputInterface $output, Finder $finder): ProgressBar
    {
        $progressBar = new ProgressBar(
            output: $output, 
            max: $finder->count(),
        );

        $progressBar->start();

        return $progressBar;
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