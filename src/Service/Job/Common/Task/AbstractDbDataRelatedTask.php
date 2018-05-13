<?php

namespace App\Service\Job\Common\Task;

use App\Service\Job\JobInterface;
use App\Service\Job\AbstractTask;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractDbDataRelatedTask extends AbstractTask
{
    /**
     * @var EntityManagerInterface
     */
    protected $dataEm;

    public function __construct(JobInterface $job, EntityManagerInterface $dataEm)
    {
        parent::__construct($job);
        $this->dataEm = $dataEm;
    }
}