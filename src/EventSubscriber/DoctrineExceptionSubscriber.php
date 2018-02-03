<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 03/02/18
 * Time: 15.56.
 */

namespace App\EventSubscriber;

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
        $re = '/Duplicate entry \'\w+\'/m';
        preg_match($re, $event->getException()->getMessage(), $matches);
        $this->setResponse($event, ['exception' => $matches[0]], 400);
    }


}
