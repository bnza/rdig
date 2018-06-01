<?php

namespace App\Service\Job\Csv\Task;

class CsvReaderCountRecordsTask extends AbstractCsvTask
{
    public function execute()
    {
        $this->getReader()->setHeaderOffset(0);
        $count = count($this->getReader());
        $this->job->setRecordCount($count);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.reader.count_records';
    }

    public function rollback()
    {
    }

}