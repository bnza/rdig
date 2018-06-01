<?php

namespace App\Service\Job\Csv;

use App\Service\Job\Csv\Task\CsvImportFindingToDbTask;

class CsvImportFindingFromFileJob extends AbstractCsvImportFromFileJob
{

    public static function getName(): string
    {
        return 'app.csv.import.from_file';
    }

    /**
     * @return string
     */
    protected function getCsvImportToDbTaskClass(): string
    {
        return CsvImportFindingToDbTask::class;
    }
}
