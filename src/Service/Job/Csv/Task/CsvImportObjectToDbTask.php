<?php

namespace App\Service\Job\Csv\Task;

use App\Entity\Main\Bucket;
use App\Entity\Main\Object;
use Doctrine\Common\Collections\Criteria;

class CsvImportObjectToDbTask extends AbstractCsvImportToDbTask
{
    protected $vocabularyKeys = [
        'voc.f.chronology.value' => 'Chronology',
        'voc.o.class.value' => 'Class',
        'voc.o.type.value' => 'Type',
        'voc.o.material_class' => 'MaterialClass',
        'voc.o.material_type' => 'MaterialType',
        'voc.o.technique.value' => 'Technique',
        'voc.o.decoration.value' => 'Decoration',
        'voc.f.color.value' => 'Color',
        'voc.o.preservation.value' => 'Preservation',
    ];

    protected $scalarKeys = [
        'finding.remarks' => 'Remarks',
        'object.no' => 'No',
        'object.retrieval_date' => 'RetrievalDate',
        'object.sub_type' => 'SubType',
        'object.height' => 'Height',
        'object.length' => 'Length',
        'object.width' => 'Width',
        'object.thickness' => 'Thickness',
        'object.diameter' => 'Diameter',
        'object.perforation_diameter' => 'PerforationDiameter',
        'object.weight' => 'Weight',
        'object.inscription' => 'Inscription',
        'object.description' => 'Description',
    ];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.import.object';
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
                'object.num' => 'No. in bucket',
                'object.no' => 'Object no.',
                'object.retrieval_date' => 'Date of retrieval',
                'voc.o.class.value' => 'Class',
                'voc.o.type.value' => 'Type',
                'object.sub_type' => 'Subtype',
                'voc.o.material_class' => 'Material class',
                'voc.o.material_type' => 'Material type',
                'voc.o.technique.value' => 'Technique',
                'voc.o.decoration.value' => 'Decoration',
                'voc.f.color.value' => 'Munsell colour',
                'voc.o.preservation.value' => 'Preservation state',
                'object.height' => 'Height',
                'object.length' => 'Length',
                'object.width' => 'Width',
                'object.thickness' => 'Thickness',
                'object.diameter' => 'Diameter',
                'object.perforation_diameter' => 'Perforation diameter',
                'object.weight' => 'Weight',
                'voc.f.chronology.value' => 'Date of object',
                'object.inscription' => 'Inscription',
                'object.description' => 'Description',
            ];
            $this->fieldsNames = array_merge(parent::getFieldNamesArray(), $fieldNames);
        }

        return $this->fieldsNames;
    }

    protected function getFindingNum(array $record): string
    {
        return $this->getRecordValue('object.num', $record);
    }

    protected function getBucketType(): string
    {
        return 'O';
    }

    protected function getEntity(Bucket $bucket, string $num)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('num', $num));
        return $bucket->getObjects()->matching($criteria)->first();
    }

    protected function createEntity(Bucket $bucket, string $num, array $record)
    {
        $pottery = new Object();
        $pottery->setBucket($bucket);
        $pottery->setNum($num);
        $this->setScalarData($pottery, $record);
        $this->setVocabularyData($pottery, $record);
        $this->persist($pottery);
    }
}
