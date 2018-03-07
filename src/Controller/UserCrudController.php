<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Site;
use App\Service\DataCrudHelper;
use App\Exceptions\CrudException;
use App\Service\EntityWrapper;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Exceptions\NotFoundCrudException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCrudController extends AbstractCrudController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $encoder;

    public function getEntityClass($entity = '')
    {
        return User::class;
    }

    public function __construct(UserPasswordEncoderInterface $encoder, ManagerRegistry $doctrine, EntityWrapper $wrapper)
    {
        $this->encoder = $encoder;
        parent::__construct($doctrine, $wrapper);
    }

    public function read(string $entityName, int $id)
    {
        $this->denyAccessUnlessGranted("$entityName|read");
        return parent::read($entityName, $id);
    }

    public function list(Request $request, string $entityName)
    {
        $this->denyAccessUnlessGranted("$entityName|read");
        return parent::list($request, $entityName);
    }

    /**
     * Create new user.
     *
     * @param Request        $request
     * @param DataCrudHelper $crud
     * @param string         $entityName
     *
     * @return JsonResponse
     *
     * @throws \App\Exceptions\DataValidationCrudException
     */
    public function create(Request $request, DataCrudHelper $crud, string $entityName)
    {
        $this->denyAccessUnlessGranted($entityName.'|create');
        $user = new User();
        $data = json_decode($request->getContent(), true);
        $user->setUsername($data['username']);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->encoder->encodePassword($user, $data['password']));
        $crud->setEntity($user)->persist();
        $response = new JsonResponse($crud->getData(), 201);
        $url = $this->generateUrl('admin__user__read', array('id' => $user->getId(), 'entityName' => $entityName));
        $response->headers->set('Location', $url);

        return $response;
    }

    /**
     * @param DataCrudHelper $crud
     * @param string         $entityName
     * @param int            $id
     *
     * @return JsonResponse
     *
     * @throws CrudException
     * @throws \App\Exceptions\InvalidRequestDataCrudException
     * @throws \App\Exceptions\NotFoundCrudException
     */
    public function delete(DataCrudHelper $crud, string $entityName, int $id)
    {
        $entity = $crud->read($this->getEntityClass($entityName), $id);
        $this->denyAccessUnlessGranted($entityName.'|delete', $entity);
        if ('admin' === $entity->getUsername()) {
            throw new CrudException('admin user cannot be deleted');
        }
        $responseArray = $crud->delete($entity, $id);
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);

        return $response;
    }

    public function changePassword(Request $request, DataCrudHelper $crud, string $entityName, int $id)
    {
        /**
         * @var User
         */
        $user = $crud->read($this->getEntityClass(), $id);
        $data = json_decode($request->getContent(), true);
        $this->denyAccessUnlessGranted('user|change-password', [$user, $this->encoder, $data['oldPassword']]);
        $user->setPassword($this->encoder->encodePassword($user, $data['newPassword']));

        return new JsonResponse(
            ['message' => sprintf('Successfully changed password for user %s', $user->getUsername())],
            200
        );
    }

    public function userAllowedSites(Request $request, DataCrudHelper $crud, int $id)
    {
        $this->denyAccessUnlessGranted("user-allowed-sites|read");

        $sort = $request->get('sort') ?: [];

        $where = $request->get('where') ?: [];

        $limit = $request->get('limit') ?: 10;

        $offset = $request->get('offset') ?: 0;

        $user = $crud->read($this->getEntityClass(), $id);
        $sites = $crud->getRepository()->getUserAllowedSites($id, $sort, $where, $limit, $offset);

        return new JsonResponse(
            $sites,
            200
        );
    }

    public function userDeniedSites(DataCrudHelper $crud, int $id)
    {
        $this->denyAccessUnlessGranted("user-allowed-sites|read");
        $user = $crud->read($this->getEntityClass(), $id);
        $sites = $crud->getRepository()->getUserDeniedSites($id);

        return new JsonResponse(
            $sites,
            200
        );
    }

    public function userAllowedSite(DataCrudHelper $crud, int $id, int $siteId)
    {
        $this->denyAccessUnlessGranted("user-allowed-sites|read");
        $user = $crud->read($this->getEntityClass(), $id);

        $site = $crud->getRepository()->getUserAllowedSite($id, $siteId);

        if (!$site) {
            throw new NotFoundCrudException("$id,allowed site");
        }

        return new JsonResponse(
            $site,
            200
        );
    }

    public function addUserAllowedSite(Request $request, DataCrudHelper $crud, int $id)
    {
        $this->denyAccessUnlessGranted("user-allowed-sites|create");
        $siteId = json_decode($request->getContent(),true)['siteId'];
        $site = $crud->read(Site::class, $siteId);
        $user = $crud->read($this->getEntityClass(), $id);
        $user->addSite($site);
        $crud->persist();

        return new JsonResponse(
            ['message' => sprintf('Successfully granted "%s" site privilege to user %s', $site->getName(), $user->getUsername())],
            200
        );
    }

    public function deleteUserAllowedSite(DataCrudHelper $crud, int $id, int $siteId)
    {
        $this->denyAccessUnlessGranted("user-allowed-sites|delete");
        $site = $crud->read(Site::class, $siteId);
        $user = $crud->read($this->getEntityClass(), $id);
        $user->removeSite($site);
        $crud->persist();

        return new JsonResponse(
            ['message' => sprintf('Successfully revoked "%s" site privilege to user %s', $site->getName(), $user->getUsername())],
            200
        );
    }
}
