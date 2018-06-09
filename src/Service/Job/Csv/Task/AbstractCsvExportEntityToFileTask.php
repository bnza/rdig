<?php

namespace App\Service\Job\Csv\Task;

use App\Event\Job\JobEvents;
use App\Event\Job\TaskEvent;

abstract class AbstractCsvExportEntityToFileTask extends AbstractCsvExportToFileTask
{
    const CHUNK_SIZE = 1000;

    protected $offsetStep = 0;

    protected $currentStep = 0;

    public function getStepsNum(): int
    {
        return $this->job->getRecordCount();
    }

    protected function getData(): array
    {
        $offset = $this->offsetStep * self::CHUNK_SIZE;
        $result = $this->job->getRepository()->findByAsArray($this->filter, $this->sort, self::CHUNK_SIZE, $offset);
        ++$this->offsetStep;

        return $result['items'];
    }

    protected function getRowValue(array $row, string $key)
    {
        $keys = explode('.', $key);
        $length = count($keys);
        $value = $row;
        for ($i = 0; $i < $length; ++$i) {
            $value = $value[$keys[$i]];
        }

        if ($value instanceof \DateTime) {
            $value = $value->format('d/m/y');
        }

        return $value;
    }

    protected function getRowValues(array $row): array
    {
        $values = [];
        foreach ($this->job->getFields() as $key => $value) {
            $values[$key] = $this->getRowValue($row, $value);
        }

        return $values;
    }

    protected function addRows()
    {
        $data = $this->getData();
        $rows = [];
        foreach ($data as $row) {
            $rows[] = $this->getRowValues($row);
            ++$this->currentStep;
        }
        $this->getWriter()->insertAll($rows);
        $this->setCurrentStepNum($this->currentStep);
        $this->job->getDispatcher()->dispatch(JobEvents::TASK_STEP_TERMINATED, new TaskEvent($this));
    }

    public function execute()
    {
        $stepCount = $this->job->getRecordCount();
        $maxOffsetStep = (int) $stepCount / self::CHUNK_SIZE;
        while ($this->offsetStep <= $maxOffsetStep) {
            if ($this->job->isCancelled()) {
                throw new \RuntimeException('Job cancelled by user input');
            }
            $this->addRows();
        }
    }
}
