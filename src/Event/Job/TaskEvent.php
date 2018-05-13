<?php

namespace App\Event\Job;

use Symfony\Component\EventDispatcher\Event;
use App\Service\Job\TaskInterface;

class TaskEvent extends Event
{
    /**
     * @var TaskInterface
     */
    protected $task;

    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * @return TaskInterface
     */
    public function getTask(): TaskInterface
    {
        return $this->task;
    }
}