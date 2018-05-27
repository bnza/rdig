<?php

namespace App\Service\Job;

use App\Entity\Job\Job as JobEntity;
use App\Event\Job\JobEvent;
use App\Event\Job\JobEvents;
use App\Event\Job\JobCreatedEvent;
use App\Event\Job\JobEventDispatcher;
use App\Repository\Job\JobRepository;
use Doctrine\ORM\EntityManagerInterface;

class JobManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var JobRepository
     */
    private $jobRepo;

    /**
     * @var JobEventDispatcher
     */
    private $dispatcher;

    /**
     * @return JobEventDispatcher
     */
    public function getDispatcher(): JobEventDispatcher
    {
        return $this->dispatcher;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * JobManager constructor.
     * @param EntityManagerInterface $em
     * @param JobEventDispatcher $dispatcher
     */
    public function __construct(EntityManagerInterface $em, JobEventDispatcher $dispatcher)
    {
        $this->em = $em;
        $this->jobRepo = $this->em->getRepository(JobEntity::class);
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param int|string $jobIdentifier
     * @return JobEntity
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function getJobEntity($jobIdentifier)
    {
        if (is_int($jobIdentifier)) {
            return $this->jobRepo->findByHash($jobIdentifier);
        } else if (is_string($jobIdentifier)) {
            return $this->jobRepo->findByHash($jobIdentifier);
        }
        throw new \InvalidArgumentException();
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

    /**
     * @param string $class
     *
     * @return string The Job Hash
     *
     * @throws \InvalidArgumentException
     */
    public function createJob(string $class)
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exists', $class));
        }
        if (!in_array(JobInterface::class, class_implements($class))) {
            $class = is_string($class) ? $class : get_class($class);
            throw new \InvalidArgumentException(
                sprintf('Class "%s" does not implement "%s" interface', $class, JobInterface::class)
            );
        }
        $jobEntity = new JobEntity();
        $jobEntity->setHash(self::generateHash());
        $jobEntity->setClass($class);
        $jobEntity->setName($class::getName());
        $this->em->persist($jobEntity);
        $this->em->flush();

        $event = new JobCreatedEvent($jobEntity);
        $this->getDispatcher()->dispatch(JobEvents::CREATED, $event);
        return $jobEntity->getHash();
    }

    /**
     * @param $hash
     * @param array $args
     * @return JobInterface
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function initJob($hash, array $args = []): JobInterface
    {
        $jobEntity = $this->getJobEntity($hash);
        $class = $jobEntity->getClass();
        //Prepend dispatcher to args
        array_unshift($args, $this->dispatcher);
        //Append Hash to args
        array_push($args, $hash);

        $job = new $class(...$args);
        $event = new JobEvent($job);
        $this->getDispatcher()->dispatch(JobEvents::INITIALIZED, $event);

        return $job;
    }

    /**
     * @param string $hash
     * @param array $args
     * @return JobInterface
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function runJob(string $hash, array $args = [])
    {
        $job = $this->initJob($hash, $args);
        $job->run();
        return $job;
    }
}