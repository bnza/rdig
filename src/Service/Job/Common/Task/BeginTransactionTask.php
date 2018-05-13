<?php

namespace App\Service\Job\Common\Task;

class BeginTransactionTask extends AbstractDbDataRelatedTask
{

    public function getName(): string
    {
        return 'app.job.task.beginTransaction';
    }

    public function execute()
    {
        $this->dataEm->beginTransaction();
    }

    public function rollback()
    {
        $this->dataEm->rollBack();
    }
}