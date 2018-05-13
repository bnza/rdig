<?php
namespace App\Event;

use Doctrine\ORM\Event\LifecycleEventArgs;

class DoctrineSqlitePreRemoveEventListener
{
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
    }
}

