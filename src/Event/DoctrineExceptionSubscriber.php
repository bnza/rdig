<?php

namespace App\Event;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Doctrine\DBAL\DBALException;

class DoctrineExceptionSubscriber extends AbstractJsonResponseExceptionSubscriber
{

    public function processException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof DBALException) {
            $this->handleException($event);
        }
    }

    public function handleUniqueConstraintViolationException(GetResponseForExceptionEvent $event)
    {
        $re = '/Duplicate entry \'\w+-?\w?\'/m';
        preg_match($re, $event->getException()->getMessage(), $matches);
        if (count($matches)) {
            $content =$matches[0];
        } else {
            $content = $event->getException()->getMessage();
        }
        $this->setResponse($event, ['exception' => $content], 400);
    }


}
