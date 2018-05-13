<?php

namespace App\Service\Job;

use App\Entity\Job\Job as JobEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface JobInterface
{
    public function getCurrentTaskIndex(): int;
    public function getTaskList();
    public static function getName(): string;
    public function getEntityManager(): EntityManagerInterface;
    public function getDispatcher(): EventDispatcherInterface;
    public function getEntity(): JobEntity;
    public function getStatus(): int;
    public function persist();
    public function run();
    public function setStatus(int $status);

}