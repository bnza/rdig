<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 11/05/18
 * Time: 11.40
 */

namespace App\Event\Job;

use Symfony\Component\EventDispatcher\Event;
use App\Service\Job\JobInterface;

class JobEvent extends Event
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