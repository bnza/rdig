<?php

namespace App\Service\Job\Csv;

use App\Service\Job\AbstractJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use League\Csv\Reader;
use League\Csv\Writer;

abstract class AbstractCsvJob extends AbstractJob
{
    /**
     * @var EntityManagerInterface;
     */
    protected $dataEm;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var Writer
     */
    protected $writer;

    /**
     * @var int
     */
    protected $recordCount;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EntityManagerInterface $em,
        EntityManagerInterface $dataEm,
        $hash = '')
    {
        parent::__construct($dispatcher, $em, $hash);
        $this->dataEm = $dataEm;
    }

    public function getReader(): Reader
    {
        return $this->reader;
    }

    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function getWriter(): Writer
    {
        return $this->writer;
    }

    public function setWriter(Writer $writer)
    {
        return $this->writer = $writer;
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