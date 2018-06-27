<?php

namespace App\Controller;

use App\Entity\Main\User;
use App\Entity\Main\Site;
use App\Service\DataCrudHelper;
use App\Exceptions\CrudException;
use App\Service\EntityWrapper;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Exceptions\NotFoundCrudException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserCrudController extends AbstractCrudDataController
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
    public function create(Request $request, DataCrudHelper $crud, string $entityName, AuthorizationCheckerInterface $authChecker)
    {
        $this->denyAccessUnlessGranted($entityName.'|create');
        $user = new User();
        $data = json_decode($request->getContent(), true);
        $user->setUsername($data['username']);
        $roles = array_key_exists('roles',$data) ? $data['roles'] : [];
        array_unshift($roles, 'ROLE_USER');
        $user->setRoles($roles);
        $user->setPassword($this->encoder->encodePassword($user, $data['password']));
        $crud->setEntity($user)->persist();
        $response = new JsonResponse($crud->getData(), 201);
        $url = $this->generateUrl('admin__user__read', array('id' => $user->getId(), 'entityName' => $entityName));
        $response->headers->set('Location', $url);

        return $response;
    }

    /**
     * @param DataCrudHelper                $crud
     * @param string                        $entityName
     * @param int                           $id
     * @param AuthorizationCheckerInterface $authChecker
     * @param UserInterface|null            $user
     *
     * @return JsonResponse
     *
     * @throws CrudException
     * @throws NotFoundCrudException
     * @throws \App\Exceptions\DataValidationCrudException
     * @throws \App\Exceptions\InvalidRequestDataCrudException
     */
    public function delete(DataCrudHelper $crud, string $entityName, int $id, AuthorizationCheckerInterface $authChecker, UserInterface $user = null)
    {
        $entity = $crud->read($this->getEntityClass($entityName), $id);
        $this->denyAccessUnlessGranted($entityName.'|delete', $entity);
        if (in_array('ROLE_SUPER_ADMIN', $entity->getRoles())) {
            throw new CrudException('super admin user cannot be deleted');
        }
        if ($user->getUsername() === $entity->getUsername()) {
            throw new CrudException('You cannot delete yourself');
        }

        $responseArray = $crud->delete($entity, $id);
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);

        return $response;
    }

    public function update(Request $request, DataCrudHelper $crud, string $entityName, AuthorizationCheckerInterface $authChecker)
    {
        $data = $request->getContent();
        $entity = $crud->read($this->getEntityClass($entityName), $data);
        /*$this->denyAccessUnlessGranted($entityName.'|update', $entity);*/

        if (!$authChecker->isGranted('ROLE_USER')) {
            return new Response('Access Denied.', '403');
        }

        $attribute = $entityName .'|update';
        if (!$authChecker->isGranted($attribute, $entity)) {
            return new Response('Access Denied', '403');
        }

        $responseArray = $crud->update($entity, $data);
        $response = new JsonResponse($responseArray['data'], $responseArray['statusCode']);

        return $response;

    }

    public function resetPassword(Request $request, DataCrudHelper $crud, string $entityName, int $id)
    {
        /**
         * @var User
         */
        $user = $crud->read($this->getEntityClass(), $id);
        $data = json_decode($request->getContent(), true);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $newPassword = substr(base64_encode(sha1(mt_rand())), 0, 8);
        $user->setPassword($this->encoder->encodePassword($user, $newPassword));
        $crud->persist();

        return new JsonResponse(
            [
                'message' => sprintf('Successfully reset password for user %s', $user->getUsername()),
                'password' => $newPassword
            ],
            200
        );
    }

    public function changeUserPassword(Request $request, DataCrudHelper $crud, UserInterface $user)
    {
        /**
         * @var User
         */
        // $user = $crud->read($this->getEntityClass(), $id);
        $data = json_decode($request->getContent(), true);
        if (is_array($data) && !array_key_exists('oldPassword', $data) || !$data['oldPassword']) {
            return new JsonResponse(
                ['error' => 'Old password must be supplied'],
                400
            );
        }
        try {
            $this->denyAccessUnlessGranted('user|change-password', [$user, $this->encoder, $data['oldPassword']]);
        } catch (AccessDeniedException $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                403
            );
        }

        if (is_array($data) && !array_key_exists('newPassword', $data) || !$data['newPassword']) {
            return new JsonResponse(
                ['error' => 'New password must be supplied'],
                400
            );
        }
        $user->setPassword($this->encoder->encodePassword($user, $data['newPassword']));
        $crud->setEntity($user)->persist();

        return new JsonResponse(
            ['message' => sprintf('Successfully changed password for user %s', $user->getUsername())],
            200
        );
    }

    public function userAllowedSites(Request $request, DataCrudHelper $crud, int $id)
    {
        $this->denyAccessUnlessGranted('user-allowed-sites|read');

        $sort = $request->get('sort') ?: [];

        $filter = $request->get('filter') ?: [];

        $limit = $request->get('limit') ?: 10;

        $offset = $request->get('offset') ?: 0;

        $sites = $this->doctrine->getRepository(Site::class)->getUserAllowedSites($id, $filter, $sort, $limit, $offset);

        return new JsonResponse(
            $sites,
            200
        );
    }

    public function userDeniedSites(DataCrudHelper $crud, int $id)
    {
        $this->denyAccessUnlessGranted('user-allowed-sites|read');
        $user = $crud->read($this->getEntityClass(), $id);
        $sites = $crud->getRepository()->getUserDeniedSites($id);

        return new JsonResponse(
            $sites,
            200
        );
    }

    public function userAllowedSite(DataCrudHelper $crud, int $id, int $siteId)
    {
        $this->denyAccessUnlessGranted('user-allowed-sites|read');
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
        $this->denyAccessUnlessGranted('user-allowed-sites|create');
        $siteId = json_decode($request->getContent(), true)['siteId'];
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
        $this->denyAccessUnlessGranted('user-allowed-sites|delete');
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
