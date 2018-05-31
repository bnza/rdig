<?php

namespace App\Command\Csv;

use App\Command\AbstractJobCommand;
use App\Service\Job\JobManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\Job\Csv\AbstractCsvImportFromFileJob;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CsvExportEntityFileCommand extends AbstractJobCommand implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $dataEm;

    /**
     * @var AbstractCsvImportFromFileJob
     */
    protected $job;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    protected $entityName;

    public static function getSubscribedEvents()
    {
        return array_merge(
            [], parent::$events
        );
    }

    public function getJobClass(): string
    {
        $entityName = ucfirst($this->entityName);

        return "\\App\\Service\\Job\\Csv\\CsvExport${entityName}ToFileJob";
    }

    public function __construct(JobManager $manager, EntityManagerInterface $dataEm, ValidatorInterface $validator)
    {
        $this->manager = $manager;
        $this->dataEm = $dataEm;
        $this->validator = $validator;
        parent::__construct($manager);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rdig:job:csv:export:to_file')
            ->setDescription('Export csv entity to file')
            ->setHelp('Export csv entity to file')
            ->addArgument('entity', InputArgument::REQUIRED, 'The entity name')
            ->addOption('filter', null, InputOption::VALUE_OPTIONAL, 'The filter array as JSON \'{"num": {"op":"gt", "value":"000004"}}\'', '[]')
            ->addOption('sort', null, InputOption::VALUE_OPTIONAL, 'The sort array as JSON e.g. \'{"context.num"="DESC"}\'', '[]');
    }

    protected function getFilter(InputInterface $input): array
    {
        $filter = $input->getOption('filter');
        $filter = json_decode($filter, true);
        if ($filter) {
            return $filter;
        }

        return [];
    }

    protected function getSort(InputInterface $input): array
    {
        $sort = $input->getOption('sort');
        $sort = json_decode($sort, true);
        if ($sort) {
            return $sort;
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $this->entityName = $input->getArgument('entity');
        $this->initJob(
            $this->getJobClass(),
            [
                $this->manager->getEntityManager(),
                $this->dataEm,
                $this->entityName,
                $this->getFilter($input),
                $this->getSort($input),
            ]);

        try {
            $this->job->run();
        } catch (\Exception $e) {
            $output->writeln('');
            $output->writeln("<error>\n\n{$e->getMessage()}\n</error>");
            $output->writeln("<error>\n\n{$e->getFile()}:{$e->getLine()}\n</error>", OutputInterface::VERBOSITY_VERBOSE);
        }
    }
}
