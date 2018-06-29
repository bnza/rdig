<?php

namespace App\Controller;

use App\Exceptions\NotFoundCrudException;
use App\Service\DataCrudHelper;
use App\Service\EntityWrapper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

abstract class AbstractCrudDataController extends AbstractCrudController
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * @var EntityWrapper
     */
    protected $wrapper;

    public function __construct(ManagerRegistry $doctrine, EntityWrapper $wrapper)
    {
        $this->doctrine = $doctrine;
        $this->wrapper = $wrapper;
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
    public function create(Request $request, DataCrudHelper $crud, string $entityName, AuthorizationCheckerInterface $authChecker)
    {
        $entity = $crud
            ->setEntity($this->getEntityClass($entityName), $request->getContent())
            ->getEntity();

        if (!$authChecker->isGranted('ROLE_USER')) {
            return new Response('Access Denied.', '403');
        }

        $attribute = $entityName.'|create';
        if (!$authChecker->isGranted($attribute, $entity)) {
            return new Response('You have not modify privilege on this site', '403');
        }

        $crud->persist();
        $responseArray = $crud->getCreateResponseArray();
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);
        if (array_key_exists('id', $responseArray)) {
            $url = $this->generateUrl('data__crud__read', array('id' => $responseArray['id'], 'entityName' => $entityName));
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    abstract public function getEntityClass($entity = '');

    /**
     * @param Request $request
     * @param string  $entityName
     *
     * @return JsonResponse
     */
    public function list(Request $request, string $entityName)
    {
        /**
         * Maps sort[code]=ASC query string to ['code'=>'ASC'] array.
         */
        $sort = $request->get('sort') ?: [];

        $filter = $request->get('filter') ?: [];

        $limit = $request->get('limit') ?: 10;
        $limit = $limit > 50 ? 50 : $limit;

        $offset = $request->get('offset') ?: 0;

        $repo = $this->getRepository($entityName);

        if ($re = $request->get('re')) {
            $entities = $repo->findByCodeRegExp($re);
        } else {
            $entities = $repo->findByAsArray($filter, $sort, $limit, $offset);
        }

        return new JsonResponse($entities);
    }

    /**
     * @param $entityName
     *
     * @return \App\Repository\AbstractDataRepository;
     */
    protected function getRepository($entityName)
    {
        return $this->doctrine->getRepository($this->getEntityClass($entityName));
    }

    /**
     * @param string $entityName
     * @param int    $id
     *
     * @return JsonResponse
     *
     * @throws NotFoundCrudException
     * @throws NonUniqueResultException
     */
    public function read(string $entityName, int $id)
    {
        $response = new JsonResponse();

        try {
            $content = $entity = $this
                ->getRepository($entityName)
                ->findAsArray($id);
        } catch (NonUniqueResultException $e) {
            throw $e;
        } catch (NoResultException $e) {
            throw new NotFoundCrudException($id);
        }

        $response->setData($content);

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
    public function update(Request $request, DataCrudHelper $crud, string $entityName, AuthorizationCheckerInterface $authChecker)
    {
        $data = $request->getContent();
        $entity = $crud->read($this->getEntityClass($entityName), $data);
        /*$this->denyAccessUnlessGranted($entityName.'|update', $entity);*/

        if (!$authChecker->isGranted('ROLE_USER')) {
            return new Response('Access Denied.', '403');
        }

        $attribute = $entityName.'|create';
        if (!$authChecker->isGranted($attribute, $entity)) {
            return new Response('You have not modify privilege on this site', '403');
        }

        $responseArray = $crud->update($entity, $data);
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);

        return $response;
    }

    /**
     * @param DataCrudHelper                $crud
     * @param string                        $entityName
     * @param int                           $id
     * @param AuthorizationCheckerInterface $authChecker
     * @param UserInterface                 $user
     *
     * @return JsonResponse
     *
     * @throws NotFoundCrudException
     * @throws \App\Exceptions\DataValidationCrudException
     * @throws \App\Exceptions\InvalidRequestDataCrudException
     */
    public function delete(DataCrudHelper $crud, string $entityName, int $id, AuthorizationCheckerInterface $authChecker, UserInterface $user = null)
    {
        $entity = $crud->read($this->getEntityClass($entityName), $id);
        if (!$authChecker->isGranted('ROLE_USER')) {
            return new Response('Access Denied.', '403');
        }

        $attribute = $entityName.'|create';
        if (!$authChecker->isGranted($attribute, $entity)) {
            return new Response('You have not modify privilege on this site', '403');
        }
        try {
            $responseArray = $crud->delete($entity);
            $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);
        } catch (ForeignKeyConstraintViolationException $e) {
            return new JsonResponse('The item you want to delete is referenced elsewhere. You cannot delete it', 400);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param string  $entityName
     * @param string  $parentEntityName
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function childList(Request $request, string $entityName, int $id, string $parentEntityName)
    {
        /**
         * Maps sort[code]=ASC query string to ['code'=>'ASC'] array.
         */
        $sort = $request->get('sort') ?: [];

        $filter = $request->get('filter') ?: [];

        $limit = $request->get('limit') ?: 10;

        $offset = $request->get('offset') ?: 0;

        // TODO check parent - child relationship
        $filter["$parentEntityName.id"] = ['op' => 'eq', 'value' => $id];

        $entities = $this
            ->getRepository($entityName)
            ->findByAsArray($filter, $sort, $limit, $offset);

        return new JsonResponse($entities);
    }
}
