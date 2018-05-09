<?php

namespace App\Entity\Job;

use App\Service\Job\JobDbLogger;
use Doctrine\ORM\Mapping as ORM;
use Psr\Log\LogLevel;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"job_id", "idx"})
 * })
 * @ORM\HasLifecycleCallbacks()
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Job
     * Many Areas have One Site.
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $job;

    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false, options={"default"=0})
     */
    private $idx = 0;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @var JobDbLogger
     * One Task has Many TaskLogs.
     * @ORM\OneToMany(targetEntity="Log", mappedBy="task")
     */
    private $logs;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return Job
     */
    public function getJob(): Job
    {
        return $this->job;
    }

    /**
     * @param Job $job
     */
    public function setJob(Job $job): void
    {
        $this->job = $job;
    }


    /**
     * @return int
     */
    public function getIdx(): int
    {
        return $this->idx;
    }

    /**
     * @param int $idx
     */
    public function setIdx(int $idx): void
    {
        $this->idx = $idx;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return JobDbLogger
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param Log $log
     */
    public function addLog(Log $log): void
    {
        $this->logs[] = $log;
        $log->setTask($this);
    }

    public function __construct() {
        $this->logs = new JobDbLogger();
    }

    /**
     * @return JobDbLogger
     */
    public function getLogger()
    {
        return $this->logs;
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        $hasError = function($key, $element) {
            $errorLevels = [
                LogLevel::EMERGENCY,
                LogLevel::CRITICAL,
                LogLevel::ERROR
            ];
            /**
             * @var Log $element
             */
            return in_array($element->getLevel(), $errorLevels);
        };
        return $this->logs->exists($hasError);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function addStartInfo()
    {
        $this->logs->info('Task started');
    }

}