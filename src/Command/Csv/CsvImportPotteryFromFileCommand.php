<?php

namespace App\Command\Csv;

use App\Service\Job\Csv\CsvImportPotteryFromFileJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CsvImportPotteryFromFileCommand extends AbstractCsvImportFromFileCommand implements EventSubscriberInterface
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
            ->setName('rdig:job:csv:import:pottery:from_file')
            ->setDescription('Import pottery CSV file into DB')
            ->setHelp('Import pottery CSV into DB')
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
        return CsvImportPotteryFromFileJob::class;
    }
}