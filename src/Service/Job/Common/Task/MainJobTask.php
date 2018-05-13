<?php

namespace App\Service\Job\Common\Task;

use App\Service\Job\AbstractTask;

class MainJobTask extends AbstractTask
{
    public function execute()
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rdig.job.main_task';
    }

    public function rollback()
    {
    }
}
