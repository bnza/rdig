<?php

namespace App\Entity\Job;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Job\JobRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Job
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, unique=true, nullable=false, options={"fixed"=true})
     */
    private $hash;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $name = '-';

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $class;

    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned"=true, "default"=0})
     */
    private $status = 0;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * One Job has Many Tasks.
     * @ORM\OneToMany(targetEntity="Task", mappedBy="job", cascade={"persist"})
     */
    private $tasks;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task): void
    {
        $this->tasks[] = $task;
        $task->setJob($this);
    }

    /**
     * @return Task
     */
    public function getMainTask()
    {
        return $this->tasks->first();
    }

    /**
     * @return Task
     */
    public function getCurrentTask()
    {
        return $this->tasks->last();
    }

    /**
     * @return int
     */
    public function getCurrentTaskIndex()
    {
        return $this->tasks->count() - 1;
    }

//    /**
//     * @param bool $main
//     * @return \App\Service\Job\JobDbLogger
//     */
//    public function getLogger(bool $main = false)
//    {
//        $task = $main ? $this->getMainTask() : $this->getCurrentTask();
//        return $task->getLogger();
//    }

    public function __construct() {
        $this->tasks = new ArrayCollection();
    }

//    /**
//     * @ORM\PrePersist
//     */
//    public function setMainTask()
//    {
//        $main = new Task();
//        $main->setName('app.job.main_task');
//        $this->addTask($main);
//    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

//    /**
//     * @return bool
//     */
//    public function hasError(): bool
//    {
//        foreach ($this->tasks as $task)
//        {
//            if ($task->hasError()) {
//                return true;
//            }
//        }
//        return false;
//    }
}