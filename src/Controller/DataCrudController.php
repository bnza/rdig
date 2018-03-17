<?php

namespace App\Controller;

use App\Exceptions\NotFoundEntityCrudException;

class DataCrudController extends AbstractCrudController
{
    protected $entities = [
        'site' => 'App\Entity\Site',
        'area' => 'App\Entity\Area',
    ];

    public function getEntityClass($entity = '')
    {
        if (array_key_exists($entity, $this->entities)) {
            return $this->entities[$entity];
        }
        throw new NotFoundEntityCrudException($entity);
    }
}
