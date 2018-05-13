<?php

namespace App\Service\Job\Csv\Task;

use App\Service\Job\Csv\AbstractCsvJob;
use League\Csv\Reader;

class CsvCountRecordsTask extends AbstractCsvTask
{
    public function execute()
    {
        $count = 0;
        foreach ($this->getReader()->getRecords() as $offset => $record) {
            ++$count;
        }
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