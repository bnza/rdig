<?php

namespace App\Event\Job;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class JobEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            JobStatusChangedEvent::NAME => [
                ['onJobChange', 100]
            ]
        ];
    }

    public function onJobStatusChange(AbstractJobEvent $event)
    {
        $this->em->persist($event->getJob()->getEntity());
    }
}