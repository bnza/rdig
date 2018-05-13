<?php

namespace App\Command\Csv;

use App\Service\Job\Csv\CsvImportObjectFromFileJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CsvImportObjectFromFileCommand extends AbstractCsvImportFromFileCommand implements EventSubscriberInterface
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
            ->setName('rdig:job:csv:import:object:from_file')
            ->setDescription('Import object CSV file into DB')
            ->setHelp('Import object CSV into DB')
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
        return CsvImportObjectFromFileJob::class;
    }
}