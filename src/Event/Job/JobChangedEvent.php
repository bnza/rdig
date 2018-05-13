<?php

namespace App\Event\Job;


class JobChangedEvent extends AbstractJobEvent
{
    const NAME = 'app.job.changed';
}