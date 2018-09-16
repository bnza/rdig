<?php

namespace App\Service\Job\Csv\Task;

class CsvExportObjectToFileTask extends AbstractCsvExportEntityToFileTask
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.export.object';
    }

    public function rollback()
    {
    }

    public function getComputedInfix(array $row): string
    {
        return 'O';
    }
}