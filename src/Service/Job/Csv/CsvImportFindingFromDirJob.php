<?php

namespace App\Service\Job\Csv;

use App\Service\Job\Csv\Task\CsvImportFindingToDbTask;

class CsvImportFindingFromDirJob extends AbstractCsvImportFromFileJob
{

    public static function getName(): string
    {
        return 'app.csv.import.from_dir';
    }

    /**
     * @return string
     */
    protected function getCsvImportToDbTaskClass(): string
    {
        return CsvImportFindingToDbTask::class;
    }
}
