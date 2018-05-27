<?php

namespace App\Service\Job;

use App\Entity\Job\Job as JobEntity;

use App\Event\Job\JobEvents;
use App\Repository\Job\JobRepository;
use App\Service\Job\Common\Task\MainJobTask;
use App\Event\Job\TaskEvent;
use App\Event\Job\JobEvent;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Runner\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractJob implements JobInterface
{
    /**
     * @var JobEntity
     */
    protected $entity;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var JobRepository
     */
    protected $repo;

    /**
     * @var int
     */
    protected $currentTaskIndex = 0;

    /**
     * @var TaskInterface[]
     */
    protected $tasks;

    /**
     * @var string
     */
    protected $error;

    /**
     * @param int|string $jobIdentifier
     * @return JobEntity
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    protected function findJobEntity($jobIdentifier)
    {
        if (!$this->entity) {
            if (is_int($jobIdentifier)) {
                return $this->repo->find($jobIdentifier);
            } else if (is_string($jobIdentifier)) {
                return $this->repo->findByHash($jobIdentifier);
            }
            throw new \InvalidArgumentException();
        }
    }

    /**
     * AbstractDbJob constructor.
     * @param EntityManagerInterface $em
     * @param EventDispatcherInterface $dispatcher
     * @param string|int $hash
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManagerInterface $em, $hash = '')
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->repo = $this->em->getRepository(JobEntity::class);
        if ($hash) {
            $this->entity = $this->findJobEntity($hash);
        } else {
            $this->entity = $this->createNewJobEntity();
            $this->persist();
        }
    }

    /**
     * Generate SHA256 pseudo unique id (64 char).
     *
     * @return string
     */
    public static function generateHash(): string
    {
        return hash('sha256', microtime());
    }

    protected function createNewJobEntity()
    {
        $jobEntity = new JobEntity();
        $jobEntity->setHash(self::generateHash());
        $jobEntity->setClass(self::class);
        $jobEntity->setName($this->getName());
        return $jobEntity;
    }

    public function persist()
    {
        $this->em->persist($this->entity);
        $this->em->flush();
    }

    /**
     * @param bool $refresh
     * @return JobEntity
     */
    public function getEntity(bool $refresh = false): JobEntity
    {
        if ($refresh) {
            $this->em->refresh($this->entity);
        }
        return $this->entity;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher;
    }

    public function getHash(): string
    {
        return $this->getEntity()->getHash();
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getEntity(true)->getStatus();
    }

    public function setStatus(int $status)
    {
        $this->getEntity()->setStatus($status);
        $this->persist();
    }

    public function setError()
    {
        $this->setStatus(
            JobStatus::setStatus($this->getStatus(), JobStatus::ERROR, true)
        );
    }

    public function setTerminated()
    {
        $status = $this->getStatus();
        $status = JobStatus::setStatus($status, JobStatus::RUNNING, false);
        $status = JobStatus::setStatus($status, JobStatus::TERMINATED, true);
        $this->setStatus($status);
    }

    public function setCancelled()
    {
        $this->setStatus(
            JobStatus::setStatus($this->getStatus(), JobStatus::CANCELLED, true)
        );
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return (bool) (JobStatus::isSuccess($this->getStatus()));
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return (bool) (JobStatus::isError($this->getStatus()));
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return (bool) ($this->getStatus() & JobStatus::CANCELLED);
    }

    public function setRunning(bool $flag)
    {
        $status = $this->getStatus();
        if ($flag) {
            if (JobStatus::isRunning($status)) {
                throw new \LogicException("Job's already running");
            } else if (JobStatus::isTerminated($status)) {
                throw new \LogicException("Cannot re-run a terminated job");
            }
        } else {
            if (!JobStatus::isRunning($status)) {
                throw new \LogicException("Job's is not running yet");
            }
        }
        $this->setStatus(JobStatus::setStatus($status, JobStatus::RUNNING, $flag));
    }

    public function configure()
    {
        $tasks = $this->getTaskList();
        array_unshift($tasks,[MainJobTask::class,[]]);
        $this->tasks = $tasks;
    }

    protected function injectTaskParameters($args)
    {
        //Prepend job instance as first parameter
        array_unshift($args, $this);
        return $args;
    }

    /**
     * @param int $i
     * @return TaskInterface
     */
    protected function initTask(int $i): TaskInterface
    {
        $task = $this->tasks[$i];

        $args = $this->injectTaskParameters($task[1]);
        $task = new $task[0](...$args);
        return $task;
    }

    public function run(): void
    {
        $jobEvent = new JobEvent($this);
        $this->configure();

        $this->setRunning(true);
        $this->dispatcher->dispatch(JobEvents::STARTED, $jobEvent);
        for ($i = 0; $i < count($this->tasks); $i++) {
            $this->currentTaskIndex = $i;
            try {
                if ($this->isCancelled()) {
                    throw new \RuntimeException('Job cancelled by user input');
                }
                $task = $this->initTask($i);
                $taskEvent = new TaskEvent($task);
                $this->dispatcher->dispatch(JobEvents::TASK_INITIALIZED, $taskEvent);
                $task->execute();
                $this->dispatcher->dispatch(JobEvents::TASK_TERMINATED, $taskEvent);
            } catch (\Exception $e) {
                $this->setTerminated();
                $this->setError();
                throw $e;
            }
        }
        $this->setTerminated();
        $this->dispatcher->dispatch(JobEvents::TERMINATED, $jobEvent);
    }

    public function getCurrentTaskIndex(): int
    {
        return $this->currentTaskIndex;
    }

}