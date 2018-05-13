<?php

namespace App\Event\Job;

use Symfony\Component\EventDispatcher\Event;
use App\Service\Job\JobInterface;

class AbstractJobEvent extends Event
{

    /**
     * @var JobInterface
     */
    protected $job;

    public function __construct(JobInterface $job)
    {
        $this->job = $job;
    }

    /**
     * @return JobInterface
     */
    public function getJob(): JobInterface
    {
        return $this->job;
    }
}