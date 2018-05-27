<?php

namespace App\Service\Job\Csv\Task;

use App\Repository\AbstractDataRepository;
use App\Entity\Main\AbstractVocabulary;
use App\Entity\Main\Bucket;
use App\Entity\Main\Context;
use App\Entity\Main\Site;
use App\Entity\Main\Area;
use App\Entity\Main\Campaign;
use App\Entity\Main\AbstractFinding;
use App\Service\Job\JobInterface;
use App\Event\Job\JobEvents;
use App\Event\Job\TaskEvent;
use App\Exceptions\CrudException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Util\Inflector;


abstract class AbstractCsvExportToFileTask extends AbstractCsvTask
{

    /**
     * @var EntityManagerInterface
     */
    protected $dataEm;

    /**
     * @var array
     */
    protected $filter;

    /**
     * @var array
     */
    protected $sort;

    public function __construct(JobInterface $job, EntityManagerInterface $dataEm, array $filter, array $sort)
    {
        parent::__construct($job);
        $this->dataEm = $dataEm;
        $this->filter = $filter;
        $this->sort = $sort;
    }

}