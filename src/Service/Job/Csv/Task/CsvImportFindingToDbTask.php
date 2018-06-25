<?php

namespace App\Service\Job\Csv\Task;

use App\Service\Job\JobInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CsvImportFindingToDbTask extends AbstractCsvTask
{
    /**
     * @var EntityManagerInterface
     */
    protected $dataEm;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    protected $classes = [
        'O' => CsvImportObjectToDbTask::class,
        'P' => CsvImportPotteryToDbTask::class,
        'S' => CsvImportSampleToDbTask::class,
    ];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.import.finding';
    }

    public function __construct(JobInterface $job, EntityManagerInterface $dataEm, ValidatorInterface $validator)
    {
        parent::__construct($job);
        $this->dataEm = $dataEm;
        $this->validator = $validator;
    }

    /**
     * @return AbstractCsvImportToDbTask
     */
    public function getTask()
    {
        $row = $this->job->getReader()->fetchOne(0);
        $type = strtoupper($row['infix']);
        $class = $this->classes[$type];
        return new $class($this->job, $this->dataEm, $this->validator);
    }

    public function execute()
    {
        $this->getTask()->execute();
    }

    public function rollback()
    {
        // TODO: Implement rollback() method.
    }
}
