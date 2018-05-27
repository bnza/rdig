<?php

namespace App\Service\Job\Csv\Task;

use App\Service\Job\AbstractTask;
use App\Service\Job\Csv\AbstractCsvJob;
use App\Service\Job\JobInterface;
use League\Csv\Reader;
use League\Csv\Writer;

abstract class AbstractCsvTask extends AbstractTask
{
    /**
     * @var AbstractCsvJob
     */
    protected $job;

    public function __construct(AbstractCsvJob $job)
    {
        parent::__construct($job);
    }

    public function getReader(): Reader
    {
        return $this->job->getReader();
    }

    public function setReader(Reader $reader)
    {
        return $this->job->setReader($reader);
    }

    public function getWriter(): Writer
    {
        return $this->job->getWriter();
    }

    public function setWriter(Writer $writer)
    {
        return $this->job->setWriter($writer);
    }
}