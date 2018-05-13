<?php

namespace App\Service\Job;

interface TaskInterface
{
    public function execute();
    public function getName(): string;
    public function getStepsNum(): int;
    public function getCurrentStepNum(): int;
    public function rollback();
    public function getJob(): JobInterface;
}