<?php

namespace App\Service\Job\Csv;

use App\Service\Job\AbstractJob;
use League\Csv\Reader;
use League\Csv\Writer;

abstract class AbstractCsvJob extends AbstractJob
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var Writer
     */
    protected $writer;

    /**
     * @var int
     */
    protected $recordCount;

    public function getReader(): Reader
    {
        return $this->reader;
    }

    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function getWriter(): Writer
    {
        return $this->writer;
    }

    public function setWriter(Writer $writer)
    {
        return $this->writer = $writer;
    }

    public function getRecordCount(): int
    {
        return $this->recordCount;
    }

    public function setRecordCount(int $count)
    {
        $this->recordCount = $count;
    }

    public function getStepsNum(): int
    {
        return 1;
    }
}