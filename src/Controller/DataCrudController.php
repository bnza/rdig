<?php

namespace App\Controller;

use App\Exceptions\NotFoundEntityCrudException;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataCrudController extends AbstractCrudDataController
{
    protected $entities = [
        'site' => 'App\Entity\Main\Site',
        'area' => 'App\Entity\Main\Area',
        'bucket' => 'App\Entity\Main\Bucket',
        'context' => 'App\Entity\Main\Context',
        'campaign' => 'App\Entity\Main\Campaign',
        'finding' => 'App\Entity\Main\Finding',
        'sample' => 'App\Entity\Main\Sample',
        'object' => 'App\Entity\Main\Object',
        'pottery' => 'App\Entity\Main\Pottery'
    ];

    /**
     * @param string $entity
     * @return mixed
     * @throws NotFoundEntityCrudException
     */
    public function getEntityClass($entity = '')
    {
        if (array_key_exists($entity, $this->entities)) {
            return $this->entities[$entity];
        }
        throw new NotFoundEntityCrudException($entity);
    }

    public function getSiteId(string $entityName, int $id)
    {
        $entity = $this->getRepository($entityName)->find($id);
        if ($entity) {
            return new JsonResponse([
                'siteId' => $entity->getSiteId()
            ]);
        }
        return new JsonResponse(['error' =>"No $entityName with ID = $id"], 400);
    }
}
