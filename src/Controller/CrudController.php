<?php

namespace App\Controller;

use App\Exceptions\NotFoundCrudException;
use App\Service\DataCrudHelper;
use App\Service\EntityWrapper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CrudController extends Controller
{
    protected $entities = [
        'site' => 'App\Entity\Site',
    ];

    public function getEntityClass($entity)
    {
        return $this->entities[$entity];
    }

    /**
     * Create new site.
     *
     * @param Request        $request
     * @param DataCrudHelper $crud
     * @param string         $entityName
     *
     * @return Response
     *
     * @throws \App\Exceptions\DataValidationCrudException
     */
    public function create(Request $request, DataCrudHelper $crud, string $entityName)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $responseArray = $crud->create($this->getEntityClass($entityName), $request->getContent());
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);
        if (array_key_exists('id', $responseArray)) {
            $url = $this->generateUrl('data__crud__read', array('id' => $responseArray['id'], 'entityName' => $entityName));
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    /**
     * @param Request         $request
     * @param ManagerRegistry $doctrine
     * @param string          $entityName
     *
     * @return JsonResponse
     */
    public function list(Request $request, ManagerRegistry $doctrine, string $entityName)
    {
        /**
         * Maps sort[code]=ASC query string to ['code'=>'ASC'] array.
         */
        $sort = $request->get('sort') ?: [];

        $entities = $doctrine
            ->getRepository($this->getEntityClass($entityName))
            ->findByAsArray([], $sort);

        return new JsonResponse($entities);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param EntityWrapper   $wrapper
     * @param string          $entityName
     * @param int             $id
     *
     * @return JsonResponse
     *
     * @throws NotFoundCrudException
     */
    public function read(ManagerRegistry $doctrine, EntityWrapper $wrapper, string $entityName, int $id)
    {
        $response = new JsonResponse();

        $entity = $doctrine
            ->getRepository($this->getEntityClass($entityName))
            ->find($id);

        if (!$entity) {
            throw new NotFoundCrudException($id);
        }

        $wrapper->setEntity($entity);
        $response->setData($wrapper->getData());

        return $response;
    }

    /**
     * @param Request        $request
     * @param DataCrudHelper $crud
     * @param string         $entityName
     *
     * @return JsonResponse
     *
     * @throws \App\Exceptions\DataValidationCrudException
     * @throws \App\Exceptions\InvalidRequestDataCrudException
     * @throws \App\Exceptions\NotFoundCrudException
     */
    public function update(Request $request, DataCrudHelper $crud, string $entityName)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $responseArray = $crud->update($this->getEntityClass($entityName), $request->getContent());
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);

        return $response;
    }

    /**
     * @param DataCrudHelper $crud
     * @param string         $entityName
     * @param $id
     *
     * @return JsonResponse
     *
     * @throws \App\Exceptions\NotFoundCrudException
     */
    public function delete(DataCrudHelper $crud, string $entityName, int $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $responseArray = $crud->delete($this->getEntityClass($entityName), $id);
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);

        return $response;
    }
}
