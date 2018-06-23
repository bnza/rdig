<?php

namespace App\Service\Job\Csv;

use App\Service\Job\Common\Task\BeginTransactionTask;
use App\Service\Job\Common\Task\CommitTransactionTask;
use App\Service\Job\Csv\Task\CsvOpenFromFileTask;
use App\Service\Job\Csv\Task\CsvReaderCountRecordsTask;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use League\Csv\Writer;

abstract class AbstractCsvImportFromFileJob extends AbstractCsvJob
{
    const IMPORT_ERROR_KEY = 'Import Error';

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $importErrorsPath;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @return string
     */
    abstract protected function getCsvImportToDbTaskClass(): string;


    public function __construct(
        EventDispatcherInterface $dispatcher,
        EntityManagerInterface $em,
        EntityManagerInterface $dataEm,
        ValidatorInterface $validator,
        $hash = '')
    {
        parent::__construct($dispatcher, $em, $dataEm, $hash);
        $this->validator = $validator;
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
                CsvReaderCountRecordsTask::class,
                []
            ],
            [
                $this->getCsvImportToDbTaskClass(),
                [
                    $this->dataEm,
                    $this->validator
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

    public function getImportErrorsPath()
    {
        if (!$this->importErrorsPath)
        {
            $this->importErrorsPath = sys_get_temp_dir() . '/errors_' . substr(basename($this->path), 0, 5) . '_' . substr($this->getHash(), 0, 4) . '.csv';
        }

        return $this->importErrorsPath;
    }

    protected function initWriter()
    {
        $writer = Writer::createFromPath($this->getImportErrorsPath(), 'w+');
        $header = $this->getReader()->getHeader();
        $header[] = self::IMPORT_ERROR_KEY;
        $writer->insertOne($header);
        $this->setWriter($writer);
    }

    public function writeImportError(array $record, int $row, string $message)
    {
        if (!$this->writer) {
            $this->initWriter();
        }
        $record[self::IMPORT_ERROR_KEY] = "row [$row]->$message";
        $this->getWriter()->insertOne($record);
    }
}
