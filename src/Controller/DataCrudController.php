<?php

namespace App\Controller;


class DataCrudController extends AbstractCrudController
{
    protected $entities = [
        'site' => 'App\Entity\Site',
    ];

    public function getEntityClass($entity = '')
    {
        return $this->entities[$entity];
    }
}