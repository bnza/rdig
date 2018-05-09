<?php

namespace App\Entity\Job;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Log
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Task
     * Many TaskLogEntry have One Site.
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="TaskLogs")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $task;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $level;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $message;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * @param Task $task
     */
    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel($level): void
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
}