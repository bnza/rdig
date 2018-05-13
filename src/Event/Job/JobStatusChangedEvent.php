<?php

namespace App\Event\Job;


class JobStatusChangedEvent extends AbstractJobEvent
{
    const NAME = 'app.job.changed.status';
}