<?php

namespace App\Command\Csv;

use App\Service\Job\Csv\CsvImportFindingFromFileJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CsvImportFindingFromFileCommand extends AbstractCsvImportFromFileCommand implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $dataEm;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rdig:job:csv:import:from_file')
            ->setDescription('Import finding CSV file into DB')
            ->setHelp('Import finding CSV into DB guessing finding type using first infix field')
            ->addArgument('filename', InputArgument::REQUIRED, 'The CSV filename');
    }

    public static function getSubscribedEvents()
    {
        return array_merge(
            [], parent::$events
        );
    }

    function getJobClass(): string
    {
        return CsvImportFindingFromFileJob::class;
    }
}