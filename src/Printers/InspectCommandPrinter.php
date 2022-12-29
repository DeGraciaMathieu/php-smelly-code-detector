<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Printers;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use DeGraciaMathieu\SmellyCodeDetector\Metrics\MethodMetric;

class InspectCommandPrinter
{
    public function __construct(
        protected array $options,
    ) {}

    public function print(OutputInterface $output, iterable $methods)
    {
        $rows = $this->getRows($methods);

        $filtetedRows = $this->applyFilters($rows);

        $this->printTable($output, $filtetedRows);

        $this->methodsHasBeenFound($output, $rows);

        return Command::SUCCESS;
    }

    protected function getRows(iterable $methods): array
    {
        $rows = [];

        foreach ($methods as $method) {

            if ($this->constructorIsUnwelcome($method)) {
                continue;
            }

            if ($this->outsideSmellThresholds($method)) {
                continue;
            }

            $rows[] = [
                $method->getFile(), 
                $method->getName(), 
                $method->getSmell(),
            ];
        }

        return $rows;
    }

    protected function constructorIsUnwelcome(MethodMetric $method): bool
    {
        return $this->options['without-constructor'] && $method->isConstructor();
    }

    protected function outsideSmellThresholds(MethodMetric $method): bool
    {
        $smell = $method->getSmell();

        if ($this->options['min-smell'] && $smell < (int) $this->options['min-smell']) {
            return true;
        }

        if ($this->options['max-smell'] && $smell > (int) $this->options['max-smell']) {
            return true;
        }

        return false;
    }

    protected function applyFilters(array $rows): array
    {
        $rows = $this->sortRows($rows);

        if ($this->options['limit']) {
            $rows = $this->cutRows($rows);
        }

        return $rows;
    }

    protected function sortRows(array $rows): array
    {
        $sort = $this->options['sort-by-smell'] ? 2 : 0;

        uasort($rows, function ($a, $b) use ($sort) {

            if ($a[$sort] == $b[$sort]) {
                return 0;
            }

            return ($a[$sort] < $b[$sort]) ? 1 : -1;
        });

        return $rows;
    }

    protected function cutRows(array $rows): array
    {
        $limit = $this->options['limit'];

        return array_slice($rows, 0, $limit);
    }

    protected function printTable(OutputInterface $output, array $rows): void
    {
        $table = new Table($output);

        $table
            ->setHeaders([
                'Files', 
                'Methods', 
                'smell',
            ])
            ->setRows($rows);

        $output->writeln('');

        $table->render();
    }

    protected function methodsHasBeenFound(OutputInterface $output, array $rows): void
    {
        $output->writeln('<info>' . count($rows) . ' methods found.</info>');
    }
}
