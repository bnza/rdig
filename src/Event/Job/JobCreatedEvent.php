<?php

namespace App\Event\Job;

use Symfony\Component\EventDispatcher\Event;
use App\Entity\Job\Job as JobEntity;

class JobCreatedEvent extends Event
{
    /**
     * @var JobEntity
     */
    protected $job;

    public function __construct(JobEntity $job)
    {
        $this->job = $job;
    }

    /**
     * @return JobEntity
     */
    public function getJob(): JobEntity
    {
        return $this->job;
    }
}