<?php

namespace App\Service\Job\Csv\Task;

class CsvFilterCountRecordsTask extends AbstractCsvExportToFileTask
{
    public function execute()
    {
        $count = $this->job->getRepository()->getFilterQueryCount($this->filter);

        $this->job->setRecordCount($count);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.filter.count_records';
    }

    public function rollback()
    {
    }

}