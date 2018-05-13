<?php

namespace App\Event\Job;


class JobEvents
{
    const CREATED = 'job.created';
    const INITIALIZED = 'job.initialized';
    const STARTED = 'job.started';
    const TERMINATED = 'job.terminated';
    const TASK_INITIALIZED = 'job.task.initialized';
    const TASK_TERMINATED = 'job.task.terminated';
    const TASK_STEP_STARTED = 'job.task.step.started';
    const TASK_STEP_TERMINATED = 'job.task.step.terminated';
}