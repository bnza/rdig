<?php

namespace App\Service\Job\Csv;

use App\Service\Job\Common\Task\BeginTransactionTask;
use App\Service\Job\Common\Task\CommitTransactionTask;
use App\Service\Job\Csv\Task\CsvOpenFromFileTask;
use App\Service\Job\Csv\Task\CsvCountRecordsTask;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractCsvImportFromFileJob extends AbstractCsvJob
{
    /**
     * @var EntityManagerInterface
     */
    protected $dataEm;

    /**
     * @var string
     */
    private $path;

    /**
     * @return string
     */
    abstract protected function getCsvImportToDbTaskClass(): string;


    public function __construct(EventDispatcherInterface $dispatcher, EntityManagerInterface $em, EntityManagerInterface $dataEm, $hash = '')
    {
        parent::__construct($dispatcher, $em, $hash);
        $this->dataEm = $dataEm;
    }

    public function setFilePath(string $path)
    {
        $this->path = $path;
    }

    public function getTaskList(): array
    {
        return [
            [
                BeginTransactionTask::class,
                [
                    $this->dataEm
                ]
            ],
            [
                CsvOpenFromFileTask::class,
                [
                    $this->path
                ]
            ],
            [
                CsvCountRecordsTask::class,
                []
            ],
            [
                $this->getCsvImportToDbTaskClass(),
                [
                    $this->dataEm
                ]
            ],
            [
                CommitTransactionTask::class,
                [
                    $this->dataEm
                ]
            ],
        ];
    }
}
