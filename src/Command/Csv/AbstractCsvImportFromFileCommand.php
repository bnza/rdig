<?php

namespace App\Command\Csv;

use App\Command\AbstractJobCommand;
use App\Service\Job\JobManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\Job\Csv\AbstractCsvImportFromFileJob;

abstract class AbstractCsvImportFromFileCommand extends AbstractJobCommand
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

    abstract function getJobClass(): string;

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
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $this->initJob(
            $this->getJobClass(),
            [
                $this->manager->getEntityManager(),
                $this->dataEm,
                $this->validator
            ]);
        $this->job->setFilePath($input->getArgument('filename'));
        try {
            $this->job->run();
        } catch (\Exception $e) {
            $output->writeln("");
            $output->writeln("<error>\n\n{$e->getMessage()}\n</error>");
            $output->writeln("<error>\n\n{$e->getFile()}:{$e->getLine()}\n</error>", OutputInterface::VERBOSITY_VERBOSE);
        }

    }
}