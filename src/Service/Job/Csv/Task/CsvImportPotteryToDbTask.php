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
        'voc.p.firing.value' => 'Firing',
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
        'pottery.restored' => 'Restored',
        'pottery.drawing_number' => 'DrawingNumber',
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
                'pottery.num' => 'fragment',
                'pottery.rim_diameter' => 'rim diameter',
                'pottery.rim_width' => 'rim width',
                'pottery.wall_width' => 'wall width',
                'pottery.max_wall_diameter' => 'max wall diameter',
                'pottery.base_width' => 'base width',
                'pottery.base_height' => 'base height',
                'pottery.base_diameter' => 'base diameter',
                'pottery.height' => 'general height',
                'voc.f.chronology.value' => 'date of sherd',
                'voc.p.class.value' => 'pottery class',
                'voc.p.preservation.value' => 'pottery preservation',
                'voc.p.shape.value' => 'pottery shape',
                'voc.p.technique.value' => 'pottery technique',
                'voc.p.surface_treatment.outer.value' => 'outer surface treatment',
                'voc.p.surface_treatment.inner.value' => 'inner surface treatment',
                'voc.p.decoration.inner.value' => 'inner decoration',
                'voc.p.decoration.outer.value' => 'outer decoration',
                'voc.p.firing.value' => 'firing',
                'voc.p.inclusions_frequency.value' => 'inclusions frequency',
                'voc.p.inclusions_size.value' => 'inclusions size',
                'voc.p.inclusions_type.value' => 'inclusions type',
                'voc.f.color.inner.value' => 'inner colour',
                'voc.f.color.outer.value' => 'outer colour',
                'voc.f.color.core.value' => 'core colour',
                'pottery.restored' => 'restored',
                'pottery.drawing_number' => 'drawing number',
            ];
            $this->fieldsNames = array_merge(parent::getFieldNamesArray(), $fieldNames);
        }

        return $this->fieldsNames;
    }

    protected function getFindingNum(array $record): string
    {
        $num = $this->getRecordValue('pottery.num', $record);
        return sprintf("%'.06s", $num);
    }

    protected function getBucketType(): string
    {
        return 'P';
    }

    protected function formatFindingNum($num)
    {
        sprintf("%'.06s", $num);
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
