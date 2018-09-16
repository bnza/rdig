<?php

namespace App\Service\Job\Csv\Task;

class CsvExportSampleToFileTask extends AbstractCsvExportEntityToFileTask
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.export.sample';
    }

    public function rollback()
    {
    }

    public function getComputedInfix(array $row): string
    {
        return 'S';
    }
}