<?php

namespace App\Service\Job\Csv\Task;

use App\Entity\Main\Bucket;
use App\Entity\Main\Sample;
use Doctrine\Common\Collections\Criteria;

class CsvImportSampleToDbTask extends AbstractCsvImportToDbTask
{
    protected $vocabularyKeys = [
        'voc.s.type.value' => 'Type',
    ];

    protected $scalarKeys = [
        'finding.remarks' => 'Remarks',
        'sample.no' => 'No',
        'sample.retrieval_date' => 'RetrievalDate',
        'sample.status' => 'Status',
    ];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.csv.import.sample';
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
                'sample.num' => 'no in bucket',
                'sample.no' => 'sample no',
                'sample.retrieval_date' => 'date of retrieval',
                'sample.status' => 'status',
                'voc.s.type.value' => 'sample type',
            ];
            $this->fieldsNames = array_merge(parent::getFieldNamesArray(), $fieldNames);
        }

        return $this->fieldsNames;
    }

    protected function getFindingNum(array $record): string
    {
        return $this->getRecordValue('sample.num', $record);
    }

    protected function getBucketType(): string
    {
        return 'S';
    }

    protected function getEntity(Bucket $bucket, string $num)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('num', $num));

        return $bucket->getObjects()->matching($criteria)->first();
    }

    protected function createEntity(Bucket $bucket, string $num, array $record)
    {
        $entity = new Sample();
        $entity->setBucket($bucket);
        $entity->setNum($num);
        $this->setScalarData($entity, $record);
        $this->setVocabularyData($entity, $record);
        $this->persist($entity);
    }
}
