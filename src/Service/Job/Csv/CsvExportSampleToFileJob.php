<?php

namespace App\Service\Job\Csv;



class CsvExportSampleToFileJob extends AbstractCsvExportFindingToFileJob
{
    public $fields = [
        'site' => 'bucket.campaign.site.code',
        'year' => 'bucket.campaign.year',
        'infix' => '__computed__.infix',
        'bucket' => 'bucket.num',
        'num' => 'num',
        'reg num' => 'no',
        'reg code' => '__computed__.code',
        'area code' => 'bucket.context.area.code',
        'area' => 'bucket.context.area.name',
        'locus type' => 'bucket.context.type',
        'locus no' => 'bucket.context.num',
        'sample type' => 'type.value',
        'status' => 'status',
        'remarks' => 'remarks',
        'loci description' => 'bucket.context.description'
        ];

    public static function getName(): string
    {
        return 'app.csv.export.sample.to_file';
    }

    public function getHeader(): array
    {
        return array_keys($this->fields);
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}