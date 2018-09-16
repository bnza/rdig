<?php

namespace App\Service\Job\Csv;



class CsvExportPotteryToFileJob extends AbstractCsvExportFindingToFileJob
{
    public $fields = [
        'site' => 'bucket.campaign.site.code',
        'year' => 'bucket.campaign.year',
        'infix' => '__computed__.infix',
        'bucket' => 'bucket.num',
        'fragment' => 'num',
        'area code' => 'bucket.context.area.code',
        'area' => 'bucket.context.area.name',
        'locus type' => 'bucket.context.type',
        'locus no' => 'bucket.context.num',
        'pottery class' => 'class.value',
        'pottery shape' => 'shape.value',
        'pottery preservation' => 'preservation.value',
        'pottery technique' => 'technique.value',
        'inclusions type' => 'inclusionsType.value',
        'inclusions size' => 'inclusionsSize.value',
        'inclusions frequency' => 'inclusionsFrequency.value',
        'inner surface treatment' => 'innerSurfaceTreatment.value',
        'outer surface treatment' => 'outerSurfaceTreatment.value',
        'inner decoration' => 'innerDecoration.value',
        'outer decoration' => 'innerDecoration.value',
        'remarks' => 'remarks',
        'firing' => 'firing.value',
        'outer colour' => 'outerColor.value',
        'inner colour' => 'innerColor.value',
        'core colour' => 'coreColor.value',
        'rim diameter' => 'rimDiameter',
        'rim width' => 'rimWidth',
        'wall width' => 'wallWidth',
        'max wall diameter' => 'maxWallDiameter',
        'base width' => 'baseWidth',
        'base height' => 'baseHeight',
        'base diameter' => 'baseDiameter',
        'general height' => 'height',
        'date of sherd' => 'chronology.value',
        'date of context' => 'bucket.context.chronology.value',
        'drawing number' => 'drawingNumber',
        'restored' => 'restored',
        'pottery location' => 'location',
        'envanterlik' => 'envanterlik',
        'etutluk' => 'etutluk',
        'loci description' => 'bucket.context.description',
        ];

    public static function getName(): string
    {
        return 'app.csv.export.pottery.to_file';
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