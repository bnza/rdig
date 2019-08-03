<?php

namespace App\Controller;

use App\Exceptions\NotFoundEntityCrudException;
use App\Repository\BucketRepository;
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
        'object' => 'App\Entity\Main\ObjectEntity',
        'phase' => 'App\Entity\Main\Phase',
        'pottery' => 'App\Entity\Main\Pottery',
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

    /**
     * @param BucketRepository $repo
     * @param string $subject
     *
     * @return JsonResponse
     */
    public function bucketRegexp(BucketRepository $repo, string $subject)
    {
        $results = $repo->getByCodePattern($subject);

/*        $repo = $this->getRepository($this->getEntityClass('bucket'));
        $results = $repo
            ->createQueryBuilder('e')
            ->orderBy('e.value')
            ->where('e.value LIKE :pattern')
            ->setMaxResults(10)
            ->setParameter('pattern', "%$pattern%")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);*/

        return new JsonResponse($results);
    }
}
