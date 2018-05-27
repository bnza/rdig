<?php

namespace App\Command\Csv;

use App\Command\AbstractJobCommand;
use App\Service\Job\Csv\CsvExportPotteryToFileJob;
use App\Service\Job\JobManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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

    function getJobClass(): string
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
            ->addArgument('entity', InputArgument::REQUIRED, 'The entity name');
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
                [],
                []
            ]);

        try {
            $this->job->run();
        } catch (\Exception $e) {
            $output->writeln("");
            $output->writeln("<error>\n\n{$e->getMessage()}\n</error>");
            $output->writeln("<error>\n\n{$e->getFile()}:{$e->getLine()}\n</error>", OutputInterface::VERBOSITY_VERBOSE);
        }

    }
}