<?php

namespace App\Service\Job\Csv;

use App\Service\Job\Csv\Task\CsvImportSampleToDbTask;

class CsvImportSampleFromFileJob extends AbstractCsvImportFromFileJob
{
    public static function getName(): string
    {
        return 'app.csv.import.sample.from_file';
    }

    /**
     * @return string
     */
    protected function getCsvImportToDbTaskClass(): string
    {
        return CsvImportSampleToDbTask::class;
    }
}
