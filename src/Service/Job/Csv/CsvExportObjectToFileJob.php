<?php

namespace App\Service\Job\Csv;



class CsvExportObjectToFileJob extends AbstractCsvExportFindingToFileJob
{
    public $fields = [
        'site' => 'bucket.campaign.site.code',
        'year' => 'bucket.campaign.year',
        'infix' => '__computed__.infix',
        'reg num' => 'no',
        'reg code' => '__computed__.code',
        'area code' => 'bucket.context.area.code',
        'area' => 'bucket.context.area.name',
        'locus type' => 'bucket.context.type',
        'locus no' => 'bucket.context.num',
        'bucket' => 'bucket.num',
        'num' => 'num',
        'date of retrieval' => 'retrievalDate',
        'coordinates e' => 'coordE',
        'coordinates n' => 'coordN',
        'elevation' => 'coordZ',
        'object class' => 'class.value',
        'object type' => 'type.value',
        'object subtype' => 'subType',
        'material type' => 'materialType.value',
        'material class' => 'materialClass.value',
        'object technique' => 'technique.value',
        'object decoration' => 'color.value',
        'object preservation state' => 'preservation.value',
        'fragments' => 'fragments',
        'object height' => 'height',
        'object length' => 'length',
        'object width' => 'width',
        'object thickness' => 'thickness',
        'object diameter' => 'diameter',
        'object perforation diameter' => 'perforationDiameter',
        'object weight' => 'thickness',
        'date of object' => 'chronology.value',
        'date of context' => 'bucket.context.chronology.value',
        'phase' => 'bucket.context.phase.name',
        // 'object date of context' => 'bucket.context.chronology.value',
        'inscription' => 'inscription',
        'description' => 'description',
        'drawing' => 'drawing',
        'photo' => 'photo',
        'year of conservation' => 'conservationYear',
        'envanterlik' => 'envanterlik',
        'etutluk' => 'etutluk',
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
