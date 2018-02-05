<?php

namespace App\Controller;

use App\Entity\Site;
use App\Exceptions\NotFoundCrudException;
use App\Service\DataCrudHelper;
use App\Service\EntityWrapper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/data")
 */
class SiteController extends Controller
{
    /**
     * Create new site.
     *
     * @param Request        $request
     * @param DataCrudHelper $crud
     *
     * @return Response
     *
     * @throws \App\Exceptions\DataValidationCrudException
     * @Route("/site", name="data__site__create")
     * @Method("POST")
     */
    public function create(Request $request, DataCrudHelper $crud)
    {
        $responseArray = $crud->create(Site::class, $request->getContent());
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);
        if (array_key_exists('id', $responseArray)) {
            $url = $this->generateUrl('data__site__read', array('id' => $responseArray['id']));
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    /**
     * @Route("/site", name="data__site__list")
     * @Method("GET")
     */
    public function list(Request $request, ManagerRegistry $doctrine)
    {

        $sortCriteria = [];
        if ($sort = $request->get('sort')) {
            $field = array_keys($sort)[0];
            $sortCriteria[$field] = $sort[$field];
        }
        $entities = $doctrine
            ->getRepository(Site::class)
            ->findByAsArray([], $sort);

        return new JsonResponse($entities);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param EntityWrapper   $wrapper
     * @param int             $id
     *
     * @return JsonResponse
     *
     * @Route("/site/{id}", name="data__site__read", requirements={"id" = "\d+"})
     * @Method("GET")
     *
     * @throws NotFoundCrudException
     */
    public function read(ManagerRegistry $doctrine, EntityWrapper $wrapper, $id)
    {
        $response = new JsonResponse();

        $entity = $doctrine
            ->getRepository(Site::class)
            ->find($id);

        if (!$entity) {
            throw new NotFoundCrudException($id);
        }

        $wrapper->setEntity($entity);
        $response->setData($wrapper->getData());

        return $response;
    }

    /**
     * @Route("/site/{id}", name="data__site__update", requirements={"id" = "\d+"})
     * @Method("PUT")
     *
     * @param Request        $request
     * @param DataCrudHelper $crud
     *
     * @return JsonResponse
     *
     * @throws \App\Exceptions\DataValidationCrudException
     * @throws \App\Exceptions\InvalidRequestDataCrudException
     * @throws \App\Exceptions\NotFoundCrudException
     */
    public function update(Request $request, DataCrudHelper $crud)
    {
        $responseArray = $crud->update(Site::class, $request->getContent());
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);

        return $response;
    }

    /**
     * @Route("/site/{id}", name="data__site__delete", requirements={"id" = "\d+"})
     * @Method("DELETE")
     *
     * @param DataCrudHelper $crud
     * @param $id
     *
     * @return JsonResponse
     *
     * @throws \App\Exceptions\NotFoundCrudException
     */
    public function delete(DataCrudHelper $crud, $id)
    {
        $responseArray = $crud->delete(Site::class, $id);
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);

        return $response;
    }
}
