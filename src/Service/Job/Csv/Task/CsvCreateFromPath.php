<?php

namespace App\Service\Job\Csv\Task;

use App\Service\Job\Csv\AbstractCsvJob;
use League\Csv\Writer;

class CsvCreateFromPath extends AbstractCsvTask
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     *
     */
    protected $header;

    public function __construct(AbstractCsvJob $job, string $path, array $header)
    {
        parent::__construct($job);
        if (!$path) {
            $path = sys_get_temp_dir() . '/errors_' . $job->getHash();
        }
        $this->path = $path;
        $this->header = $header;
    }

    public function execute()
    {
        $writer = Writer::createFromPath($this->path, 'w+');
        $this->setWriter($writer);
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