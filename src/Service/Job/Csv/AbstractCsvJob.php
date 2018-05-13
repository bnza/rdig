<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 11/05/18
 * Time: 11.14
 */

namespace App\Service\Job\Csv;

use App\Service\Job\AbstractJob;
use League\Csv\Reader;


abstract class AbstractCsvJob extends AbstractJob
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var int
     */
    protected $recordCount;

    public function getReader(): Reader
    {
        return $this->reader;
    }

    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function getRecordCount(): int
    {
        return $this->recordCount;
    }

    public function setRecordCount(int $count)
    {
        $this->recordCount = $count;
    }

    public function getStepsNum(): int
    {
        return 1;
    }
}