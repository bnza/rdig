<?php

namespace App\Service\Job\Common\Task;


class CommitTransactionTask extends AbstractDbDataRelatedTask
{

    public function getName(): string
    {
        return 'app.job.task.commitTransaction';
    }

    public function execute()
    {
        $this->dataEm->commit();
    }

    public function rollback()
    {
    }
}
