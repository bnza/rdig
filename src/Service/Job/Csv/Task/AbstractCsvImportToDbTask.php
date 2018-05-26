<?php

namespace App\Service\Job\Csv\Task;

use App\Entity\Main\AbstractVocabulary;
use App\Entity\Main\Bucket;
use App\Entity\Main\Context;
use App\Entity\Main\Site;
use App\Entity\Main\Area;
use App\Entity\Main\Campaign;
use App\Entity\Main\AbstractFinding;
use App\Service\Job\JobInterface;
use App\Event\Job\JobEvents;
use App\Event\Job\TaskEvent;
use App\Exceptions\CrudException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Util\Inflector;
use Symfony\Component\Validator\Validator\ValidatorInterface;


abstract class AbstractCsvImportToDbTask extends AbstractCsvTask
{

    /**
     * @var array
     */
    protected $fieldsNames;

    /**
     * @var EntityManagerInterface
     */
    protected $dataEm;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(JobInterface $job, EntityManagerInterface $dataEm, ValidatorInterface $validator)
    {
        parent::__construct($job);
        $this->dataEm = $dataEm;
        $this->validator = $validator;
    }

    /**
     * @return array
     */
    abstract protected function getVocabularyKeys(): array;

    /**
     * @return array
     */
    abstract protected function getScalarKeys(): array;

    /**
     * @param Bucket $bucket
     * @param string $num
     * @return AbstractFinding|bool
     */
    abstract protected function getEntity(Bucket $bucket, string $num);

    /**
     * @param array $record
     * @return string
     */
    abstract protected function getFindingNum(array $record): string;

    /**
     * @return string
     */
    abstract protected function getBucketType(): string;

    /**
     * @param Bucket $bucket
     * @param string $num
     * @param array $record
     * @return void
     */
    abstract protected function createEntity(Bucket $bucket, string $num, array $record);

    public function rollback()
    {
    }

    public function getStepsNum(): int
    {
        return $this->job->getRecordCount();
    }

    protected function getFieldNamesArray()
    {
        return [
            'site.code' => 'site',
            'area.name' => 'area',
            'campaign.year' => 'year',
            'context.num' => 'locus no',
            'context.description' => 'loci description',
            'context.type' => 'locus type',
            'bucket.num' => 'bucket',
            'finding.remarks' => 'remarks'
        ];
    }

    private function getDataEntityManager() {
        return $this->dataEm;
    }

    protected function getRecordValue(string $key, array $record)
    {
        $field = $this->getFieldNamesArray()[$key];
        return trim($record[$field]);
    }

    /**
     * @param $entity
     * @throws CrudException
     */
    protected function persist($entity)
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            throw new CrudException($errorsString);
        }

        $this->getDataEntityManager()->persist($entity);
        $this->getDataEntityManager()->flush();
    }

    protected function getSite(array $record): Site
    {
        $code = $this->getRecordValue('site.code', $record);
        $repo = $this->getDataEntityManager()->getRepository(Site::class);
        $site = $repo->findByCode($code);
        if (!$site) {
            $site = new Site();
            $site->setCode($code);
            $site->setName("site $code");
            $this->persist($site);
        }
        return $site;
    }

    /**
     * Normalize Area code using name
     * @param string $name
     * @return string
     */
    protected function getAreaCode(string $name): string
    {
        $pattern="/(area\s+)?(\w+)/i";
        preg_match_all($pattern,$name,$matches);
        $count = count($matches[2]);
        $code = $count ? $matches[2][0] : '';
        $code = strtoupper(trim($code));
        $count = count($matches[2]);
        if (strlen($code) > 2) {
            $code = substr($code, 0, 3);
        } else if (count($matches[2]) > 1) {
            for ($i = 1; $i < $count; $i++) {
                $code .= strtoupper(substr($matches[2][$i], 0, 1));
            }
        }
        return $code;
    }

    protected function getArea(array $record): Area
    {
        $site = $this->getSite($record);
        $name = $this->getRecordValue('area.name', $record);

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('name', $name));
        $this->getDataEntityManager()->refresh($site);
        $area = $site->getAreas()->matching($criteria)->first();

        if (!$area) {
            $code = $this->getAreaCode($name);
            $area = new Area();
            $area->setSite($site);
            $area->setCode($code);
            $area->setName($name);
            $this->persist($area);
        }
        return $area;
    }

    protected function normalizeYear(string $year): int
    {
        if (strlen($year) < 4) {
            $year = sprintf('2%03s', $year);
        }
        return (int) $year;
    }

    protected function getCampaign(array $record): Campaign
    {
        $site = $this->getSite($record);
        $year = $this->getRecordValue('campaign.year', $record);
        $year = $this->normalizeYear($year);

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('year', $year));
        $this->getDataEntityManager()->refresh($site);
        $campaign = $site->getCampaigns()->matching($criteria)->first();

        if (!$campaign) {
            $campaign = new Campaign();
            $campaign->setSite($site);
            $campaign->setYear($year);
            $this->persist($campaign);
        }
        return $campaign;
    }

    protected function getContext(array $record): Context
    {
        $area = $this->getArea($record);
        $num = (int) $this->getRecordValue('context.num', $record);
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('num', $num));
        $this->getDataEntityManager()->refresh($area);
        $context = $area->getContexts()->matching($criteria)->first();
        if (!$context) {
            $type = strtoupper($this->getRecordValue('context.type', $record));
            $context = new Context();
            $context->setArea($area);
            $context->setNum($num);
            $context->setType($type);
            $description = $this->getRecordValue('context.description', $record);
            if ($description) {
                $context->setDescription($description);
            }
            $this->persist($context);
        }
        return $context;
    }

    protected function getBucket(array $record, string $type): Bucket
    {
        $context = $this->getContext($record);
        $num = sprintf("%'.05s", $this->getRecordValue('bucket.num', $record));
        //$num = $this->getFindingNum($record);
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('num', $num));
        $this->getDataEntityManager()->refresh($context);
        $bucket = $context->getBuckets()->matching($criteria)->first();

        if (!$bucket) {
            $campaign = $this->getCampaign($record);
            $bucket = new Bucket();
            $bucket->setType($type);
            $bucket->setNum($num);
            $bucket->setCampaign($campaign);
            $bucket->setContext($context);
            $this->persist($bucket);
        }
        return $bucket;
    }

    protected function setScalarData($pottery, $record)
    {
        foreach ($this->getScalarKeys() as $key => $field) {
            $value = $this->getRecordValue($key, $record);
            if ($value) {
                $method = "set$field";
                $pottery->$method($value);
            }
        }
    }

    protected function setVocabularyData($entity, array $record)
    {
        $skipLowerCase = [
            'voc.f.color.inner.value',
            'voc.f.color.outer.value',
            'voc.f.color.core.value',
            'voc.f.chronology.value'
        ];

        foreach ($this->getVocabularyKeys() as $key => $field)
        {
            $value = trim($this->getRecordValue($key, $record));
            if (!in_array($key, $skipLowerCase)) {
                $value = strtolower($value);
            }
            if (!$value) {
                continue;
            }
            $vocabulary = $this->getVocabulary($key, $value);
            $method = "set$field";
            $entity->$method($vocabulary);
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @return AbstractVocabulary
     * @throws CrudException
     */
    protected function getVocabulary(string $key, string $value): AbstractVocabulary
    {
        if (preg_match('@(voc)\.([f|o|p|s])\.(\w+)@', $key, $matches))
        {
            $class = 'App\\Entity\\Main\\' . ucfirst($matches[1]) . ucfirst($matches[2]) . ucfirst(Inflector::classify($matches[3]));
            $results = $this->getDataEntityManager()->getRepository($class)->findByValue($value);
            $vocabulary = count($results) ? $results[0] : false;
            if (!$vocabulary) {
                $vocabulary = new $class;
                $vocabulary->setValue($value);
                $this->persist($vocabulary);
            }
            return $vocabulary;
        } else {
            throw new \InvalidArgumentException("$key does not match any vocabulary");
        }
    }

    /**
     * @throws \League\Csv\Exception
     * @throws \Exception
     */
    public function execute()
    {
        $reader = $this->getReader();
        $reader->setHeaderOffset(0);
        $records = $reader->getRecords();
        $errors = 0;
        foreach ($records as $offset => $record) {
            if ($this->job->isCancelled()) {
                throw new \RuntimeException('Job cancelled by user input');
            }
            $this->setCurrentStepNum($offset + 1);
            try {
                $this->insertRecord($record);
            } catch (CrudException $e)
            {
                ++$errors;
                $this->job->writeImportError($record, $this->getCurrentStepNum(), $e->getMessage());
            } /*catch (\Doctrine\DBAL\Types\ConversionException $e)
            {
                throw $e;
            }*/
            $this->job->getDispatcher()->dispatch(JobEvents::TASK_STEP_TERMINATED, new TaskEvent($this));
        }
        if ($errors) {
        /*    throw new \Exception(
                sprintf("Failed to insert %d rows\nSee %s for details", $errors, $this->job->getImportErrorsPath())
            );*/
        }
    }

    /**
     * @param array $record
     */
    protected function insertRecord(array $record)
    {
        $bucket = $this->getBucket($record, $this->getBucketType());

        $num = $this->getFindingNum($record);

        $entity = $this->getEntity($bucket, $num);

        if (!$entity) {
            $this->createEntity($bucket, $num, $record);
        }
    }
}