<?php

namespace App\Service\Job\Csv\Task;

use App\Repository\AbstractDataRepository;
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


abstract class AbstractCsvExportEntityToFileTask extends AbstractCsvExportToFileTask
{
    const CHUNK_SIZE = 100;

    protected $offsetStep = 0;

    public function getStepsNum(): int
    {
        return $this->job->getRecordCount();
    }

    protected function getData(): array
    {
        $offset =  $this->offsetStep * self::CHUNK_SIZE;
        $result = $this->job->getRepository()->findByAsArray($this->filter,$this->sort,self::CHUNK_SIZE, $offset);
        $this->offsetStep++;
        return $result['items'];
    }

    protected function getRowValue(array $row, string $key)
    {
        $keys = explode('.',$key);
        $length = count($keys);
        $value = $row;
        for ($i = 0; $i < $length; $i++) {
            $value = $value[$keys[$i]];
        }
        return $value;
    }

    protected function getRowValues(array $row): array
    {
        $values = [];
        foreach ($this->job->getFields() as $key => $value)
        {
            $values[$key] = $this->getRowValue($row, $value);
        }
        return $values;
    }

    protected function addRow(array $row)
    {
        $values = $this->getRowValues($row);
        $this->getWriter()->insertOne($values);
    }

    protected function addRows()
    {
        $data = $this->getData();
        foreach ($data as $row) {
            $this->addRow($row);
            $this->setCurrentStepNum($this->getCurrentStepNum() + 1);
            $this->job->getDispatcher()->dispatch(JobEvents::TASK_STEP_TERMINATED, new TaskEvent($this));
        }
    }

    public function execute()
    {
        $stepCount = $this->job->getRecordCount();
        $maxOffsetStep = (int) $stepCount/self::CHUNK_SIZE;
        //while ($this->getCurrentStepNum() < $this->getStepsNum()) {
        while ($this->offsetStep <= $maxOffsetStep) {
            if ($this->job->isCancelled()) {
                throw new \RuntimeException('Job cancelled by user input');
            }
            $this->addRows();
        }

    }
}