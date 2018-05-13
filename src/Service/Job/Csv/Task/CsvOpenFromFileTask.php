<?php

namespace App\Service\Job\Csv\Task;

use App\Service\Job\Csv\AbstractCsvJob;
use League\Csv\Reader;

class CsvOpenFromFileTask extends AbstractCsvTask
{
    /**
     * @var string
     */
    protected $path;

    public function __construct(AbstractCsvJob $job, string $path)
    {
        parent::__construct($job);
        $this->path = $path;
    }

    public function execute()
    {
        $reader = Reader::createFromPath($this->path, 'r');
        $this->setReader($reader);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.reader.create_from_path';
    }

    public function rollback()
    {
    }
}