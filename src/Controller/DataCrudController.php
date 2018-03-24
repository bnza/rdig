<?php

namespace App\Controller;

use App\Exceptions\NotFoundEntityCrudException;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataCrudController extends AbstractCrudController
{
    protected $entities = [
        'site' => 'App\Entity\Site',
        'area' => 'App\Entity\Area',
        'bucket' => 'App\Entity\Bucket',
        'context' => 'App\Entity\Context',
        'campaign' => 'App\Entity\Campaign'
    ];

    public function getEntityClass($entity = '')
    {
        if (array_key_exists($entity, $this->entities)) {
            return $this->entities[$entity];
        }
        throw new NotFoundEntityCrudException($entity);
    }

    public function getSiteId(string $entityName, int $id)
    {
        return new JsonResponse([
            'siteId' => $this->getRepository($entityName)->find($id)->getSiteId()
        ]);
    }
}
