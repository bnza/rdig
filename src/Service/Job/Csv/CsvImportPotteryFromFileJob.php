<?php

namespace App\Service\Job\Csv;

use App\Service\Job\Csv\Task\CsvImportPotteryToDbTask;

class CsvImportPotteryFromFileJob extends AbstractCsvImportFromFileJob
{
    public static function getName(): string
    {
        return 'app.csv.import.pottery.from_file';
    }

    /**
     * @return string
     */
    protected function getCsvImportToDbTaskClass(): string
    {
        return CsvImportPotteryToDbTask::class;
    }
}
