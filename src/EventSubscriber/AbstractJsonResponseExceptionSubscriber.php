<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 03/02/18
 * Time: 17.14
 */

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;


abstract class AbstractJsonResponseExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array(
                array('processException', 10),
            ),
        );
    }

    abstract function processException(GetResponseForExceptionEvent $event);

    protected function setResponse($event, $error, int $status = 200, array $headers = array(), bool $json = false) {
        $data = ['error' => $error];
        $response = new JsonResponse($data, $status, $headers, $json);
        $event->setResponse($response);
    }

    protected function getClassName($object)
    {
        $namespacedClassname = get_class($object);
        $classname = substr($namespacedClassname, strrpos($namespacedClassname, '\\') + 1);
        return $classname;
    }

    protected function handleException(GetResponseForExceptionEvent $event)
    {
        $classname = $this->getClassName($event->getException());
        $method = 'handle'.$classname;
        if (method_exists($this, $method)) {
            $this->$method($event);
        }
    }
}