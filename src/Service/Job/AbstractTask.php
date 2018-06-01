<?php

namespace App\Service\Job;

use App\Service\Job\JobInterface;
use App\Entity\Job\Task as TaskEntity;


abstract class AbstractTask implements TaskInterface
{

    /**
     * @var JobInterface
     */
    protected $job;

    /**
     * @var TaskEntity
     */
    protected $entity;

    public function __construct(JobInterface $job)
    {
        $this->job = $job;
        $this->createNewTaskEntity();
    }

    protected function createNewTaskEntity()
    {
        $taskEntity = new TaskEntity();
        $taskEntity->setName($this->getName());
        $this->entity = $taskEntity;
        $jobEntity = $this->job->getEntity();
        $jobEntity->addTask($this->entity);
        $this->job->persist();
    }


    public function getJob(): JobInterface
    {
        return $this->job;
    }

    /**
     * @param JobInterface $job
     */
    public function setJob(JobInterface $job)
    {
        $this->job = $job;
    }

    /**
     * @return int
     */
    public function getStepsNum(): int
    {
        return $this->entity->getStepNum();
    }

    public function setStepNum(int $num)
    {
        $this->entity->setStepNum($num);
        $this->job->persist();
    }

    public function getCurrentStepNum(): int
    {
        return $this->entity->getCurStep();
    }

    public function setCurrentStepNum(int $num)
    {
        $this->entity->setCurStep($num);
        $this->job->persist();
    }
}