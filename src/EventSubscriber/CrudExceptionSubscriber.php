<?php

namespace App\EventSubscriber;

use App\Exceptions\CrudException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class CrudExceptionSubscriber extends AbstractJsonResponseExceptionSubscriber
{
    public function processException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof CrudException) {
            $this->handleException($event);
        }
    }

    public function handleNotFoundCrudException(GetResponseForExceptionEvent $event)
    {
        $this->setResponse($event, ['exception' => $event->getException()->getMessage()], 404);
    }

    public function handleConflictCrudException(GetResponseForExceptionEvent $event)
    {
        $this->setResponse($event, ['exception' => $event->getException()->getMessage()], 409);
    }

    public function handleDataValidationCrudException(GetResponseForExceptionEvent $event)
    {
        $this->setResponse($event, ['violations' => $this->formatValidateErrors($event->getException()->getErrors())], 400);
    }

    protected function formatValidateErrors($errors)
    {
        $_errors = [];
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $error = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
                array_push($_errors, $error);
            }
        }

        return $_errors;
    }
}
