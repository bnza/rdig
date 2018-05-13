<?php

namespace App\Command;

use App\Event\Job\JobCreatedEvent;
use App\Service\Job\AbstractTask;
use App\Service\Job\JobManager;
use App\Service\Job\JobInterface;
use App\Event\Job\TaskEvent;
use App\Event\Job\JobEvent;
use App\Event\Job\JobEvents;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractJobCommand extends ContainerAwareCommand
{
    /**
     * @var JobInterface
     */
    protected $job;

    /**
     * @var JobManager
     */
    protected $manager;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var string The sprintf format used by output
     */
    protected $placeMarkStepFormat;

    /**
     * @var array
     */
    protected static $events = [
        JobEvents::CREATED => ['onJobCreatedEvent', 0],
        JobEvents::INITIALIZED => ['onJobInitializedEvent', 0],
        JobEvents::STARTED => ['onJobStartedEvent', 0],
        JobEvents::TERMINATED => ['onJobTerminatedEvent', 0],
        JobEvents::TASK_INITIALIZED => ['onTaskInitializedEvent', 0],
        JobEvents::TASK_TERMINATED => ['onTaskTerminatedEvent', 0],
        JobEvents::TASK_STEP_TERMINATED => ['onTaskStepTerminatedEvent', 0],
        JobEvents::TASK_STEP_STARTED => ['onTaskStepStartedEvent', 0],
        ];

    protected function initJob(string $class, array $args = [])
    {
        $hash = $this->manager->createJob($class);
        $this->job = $this->manager->initJob($hash, $args);

        return $this->job;
    }

    protected function setJob(JobInterface $job)
    {
        $this->job = $job;
    }

    public function getJob(): JobInterface
    {
        return $this->job;
    }

    public function __construct(JobManager $manager)
    {
        $this->manager = $manager;
        parent::__construct();
        $this->manager->getDispatcher()->addSubscriber($this);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
    }

    public function onJobCreatedEvent(JobCreatedEvent $event)
    {
        if ($this->output) {
            $this->output->write("[{$event->getJob()->getHash()}] job created");
        }
    }

    public function onJobInitializedEvent(JobEvent $event)
    {
        if ($this->output) {
            $tasks = count($event->getJob()->getTaskList());
            $this->output->writeln(" and correctly initialized ($tasks tasks)");
        }
    }

    public function onJobStartedEvent(JobEvent $event)
    {
        if ($this->output) {
            $this->output->writeln('');
        }
    }

    public function onJobTerminatedEvent(JobEvent $event)
    {
        if ($this->output) {
            $job = $event->getJob();
            $start = $job->getEntity()->getCreatedAt();
            $end = $job->getEntity()->getTasks()->last()->getUpdatedAt();
            $duration = $start->diff($end);
            $this->output->writeln("<info>Done</info> in {$duration->format('%h:%I:%S.%f')}</info>");
        }
    }

    public function onTaskInitializedEvent(TaskEvent $event)
    {
        if ($this->output) {
            $task = $event->getTask();
            $job = $task->getJob();
            $currentTask = $job->getCurrentTaskIndex();
            $tasks = count($job->getTaskList());
            $this->setUpStepFormat($task);

            $this->output->write("[$currentTask/$tasks] - {$task->getName()} ");
            $this->outputCounter(0, $task->getStepsNum(), false);
        }
    }

    public function onTaskStepTerminatedEvent(TaskEvent $event)
    {
        if ($this->output) {
            $task = $event->getTask();
            $this->outputCounter($task->getCurrentStepNum(), $task->getStepsNum());
        }

    }

    public function onTaskTerminatedEvent(TaskEvent $event)
    {
        if ($this->output) {
            $task = $event->getTask();
            $this->outputCounter($task->getStepsNum(), $task->getStepsNum());
            $this->output->writeln('.');
        }
    }

    /**
     * Set up the sprint format used by the onAfterIteratePlaceMark method.
     *
     * @param AbstractTask $task
     */
    protected function setUpStepFormat(AbstractTask $task)
    {
        $length = strlen($task->getStepsNum());
        $this->placeMarkStepFormat = "%0{$length}u/%0{$length}u";
    }

    protected function outputCounter(int $current, int $total, $erase = true)
    {
        $bs = "\x08";
        $counter = sprintf($this->placeMarkStepFormat, $current, $total);
        $backSpace = $erase ? str_repeat($bs, strlen($counter)) : '';
        $this->output->write($backSpace.$counter);
    }
}
