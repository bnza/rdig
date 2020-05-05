<?php

namespace App\Service\Job\Csv\Task;

use App\Entity\Main\Bucket;
use App\Entity\Main\ObjectEntity;
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
        'object.drawing' => 'Drawing',
        'object.photo' => 'Photo',
        'object.envanterlik' => 'Envanterlik',
        'object.etutluk' => 'Etutluk',
        'object.location' => 'Location',
        'object.fragments' => 'Fragments',
        'object.coordinate_n' => 'CoordN',
        'object.coordinate_e' => 'CoordE',
        'object.coordinate_z' => 'CoordZ',
        'object.conservation_year' => 'ConservationYear'
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
                'object.num' => 'no in bucket',
                'object.no' => 'object no',
                'object.retrieval_date' => 'date of retrieval',
                'voc.o.class.value' => 'object class',
                'voc.o.type.value' => 'object type',
                'object.sub_type' => 'object subtype',
                'voc.o.material_class' => 'material class',
                'voc.o.material_type' => 'material type',
                'voc.o.technique.value' => 'object technique',
                'voc.o.decoration.value' => 'object decoration',
                'voc.f.color.value' => 'object munsell colour',
                'voc.o.preservation.value' => 'object preservation state',
                'object.fragments' => 'fragments',
                'object.height' => 'object height',
                'object.length' => 'object length',
                'object.width' => 'object width',
                'object.thickness' => 'object thickness',
                'object.diameter' => 'object diameter',
                'object.perforation_diameter' => 'object perforation diameter',
                'object.weight' => 'object weight',
                'voc.f.chronology.value' => 'date of object',
                'object.inscription' => 'inscription',
                'object.description' => 'description',
                'object.drawing' => 'drawing',
                'object.photo' => 'photo',
                'object.envanterlik' => 'envanterlik',
                'object.etutluk' => 'etutluk',
                'object.location' => 'location',
                'object.coordinate_n' => 'coordinates n',
                'object.coordinate_e' => 'coordinates e',
                'object.coordinate_z' => 'elevation',
                'object.conservation_year' => 'year of conservation'
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
        return $bucket->getFindings()->matching($criteria)->first();
    }

    protected function setFindingNo (ObjectEntity $object, array $record)
    {
        preg_match('/(\d+)([[:alpha:]]?)$/', $this->getRecordValue('object.no', $record) ,$matches);
        $object->setNo((int) $matches[1]);
        if (isset($matches[2]) && $matches[2]) {
            $object->setDuplicate($matches[2]);
        }
    }

    protected function createEntity(Bucket $bucket, string $num, array $record)
    {
        $object = new ObjectEntity();
        $object->setBucket($bucket);
        $object->setCampaign($this->getCampaign($record));
        $object->setNum($num);
        $this->setFindingNo($object, $record);
        $this->setScalarData($object, $record);
        $this->setVocabularyData($object, $record);
        $this->persist($object);
    }
}
