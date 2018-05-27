<?php

namespace App\Service\Job\Csv\Task;

class CsvExportPotteryToFileTask extends AbstractCsvExportEntityToFileTask
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.export.pottery';
    }

    public function rollback()
    {
    }
}