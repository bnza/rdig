<?php

namespace App\Service\Job\Csv\Task;

use App\Entity\Main\Bucket;
use App\Entity\Main\Pottery;
use Doctrine\Common\Collections\Criteria;

class CsvImportPotteryToDbTask extends AbstractCsvImportToDbTask
{
    protected $vocabularyKeys = [
        'voc.f.chronology.value' => 'Chronology',
        'voc.p.class.value' => 'Class',
        'voc.p.preservation.value' => 'Preservation',
        'voc.p.shape.value' => 'Shape',
        'voc.p.technique.value' => 'Technique',
        'voc.p.surface_treatment.outer.value' => 'OuterSurfaceTreatment',
        'voc.p.surface_treatment.inner.value' => 'InnerSurfaceTreatment',
        'voc.p.decoration.inner.value' => 'InnerDecoration',
        'voc.p.decoration.outer.value' => 'OuterDecoration',
        'voc.p.inclusions_frequency.value' => 'InclusionsFrequency',
        'voc.p.inclusions_size.value' => 'InclusionsSize',
        'voc.p.inclusions_type.value' => 'InclusionsType',
        'voc.f.color.inner.value' => 'InnerColor',
        'voc.f.color.outer.value' => 'OuterColor',
        'voc.f.color.core.value' => 'CoreColor',
    ];

    protected $scalarKeys = [
        'finding.remarks' => 'Remarks',
        'pottery.rim_diameter' => 'RimDiameter',
        'pottery.rim_width' => 'RimWidth',
        'pottery.wall_width' => 'WallWidth',
        'pottery.max_wall_diameter' => 'MaxWallDiameter',
        'pottery.base_width' => 'BaseWidth',
        'pottery.base_height' => 'BaseHeight',
        'pottery.base_diameter' => 'BaseDiameter',
        'pottery.height' => 'Height',
    ];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.import.pottery';
    }

    protected function getVocabularyKeys(): array
    {
        return $this->vocabularyKeys;
    }

    protected function getScalarKeys(): array
    {
        return $this->scalarKeys;
    }

    protected function getFieldNamesArray()
    {
        if (!$this->fieldsNames) {
            $fieldNames = [
                'pottery.num' => 'Fragment',
                'pottery.rim_diameter' => 'Rim Diameter',
                'pottery.rim_width' => 'Rim Width',
                'pottery.wall_width' => 'Wall Width',
                'pottery.max_wall_diameter' => 'Max Wall Diameter',
                'pottery.base_width' => 'Base Width',
                'pottery.base_height' => 'Base Height',
                'pottery.base_diameter' => 'Base Diameter',
                'pottery.height' => 'Height',
                'voc.f.chronology.value' => 'Date of sherd',
                'voc.p.class.value' => 'Class',
                'voc.p.preservation.value' => 'Preservation',
                'voc.p.shape.value' => 'Shape',
                'voc.p.technique.value' => 'Technique',
                'voc.p.surface_treatment.outer.value' => 'Outer Surface Treatment',
                'voc.p.surface_treatment.inner.value' => 'Inner Surface Treatment',
                'voc.p.decoration.inner.value' => 'Inner Decoration',
                'voc.p.decoration.outer.value' => 'Outer Decoration',
                'voc.p.firing.value' => 'Firing',
                'voc.p.inclusions_frequency.value' => 'Inclusions Frequency',
                'voc.p.inclusions_size.value' => 'Inclusions Size',
                'voc.p.inclusions_type.value' => 'Inclusions Type',
                'voc.f.color.inner.value' => 'Inner color',
                'voc.f.color.outer.value' => 'Outer color',
                'voc.f.color.core.value' => 'Core color',
            ];
            $this->fieldsNames = array_merge(parent::getFieldNamesArray(), $fieldNames);
        }

        return $this->fieldsNames;
    }

    protected function getFindingNum(array $record): string
    {
        return sprintf('%04d', (int) $this->getRecordValue('pottery.num', $record));
    }

    protected function getBucketType(): string
    {
        return 'P';
    }

    protected function getEntity(Bucket $bucket, string $num)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('num', $num));
        return $bucket->getPotteries()->matching($criteria)->first();
    }

    protected function createEntity(Bucket $bucket, string $num, array $record)
    {
        $pottery = new Pottery();
        $pottery->setBucket($bucket);
        $pottery->setNum($num);
        $this->setScalarData($pottery, $record);
        $this->setVocabularyData($pottery, $record);
        $this->persist($pottery);
    }
}
