<?php

namespace App\Controller;

use App\Exceptions\CrudException;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * @Route("/voc")
 */
class VocabularyController extends AbstractCrudController
{
    /**
     * @param string $name
     * @param string $type
     *
     * @return string
     *
     * @throws CrudException
     */
    public function getEntityClass(string $type, string $name): string
    {
        $chunks = explode('-', $name);
        $name = '';
        foreach ($chunks as $chunk) {
            $name .= ucfirst($chunk);
        }
        $type = strtoupper($type);
        $class = "App\\Entity\\Main\\Voc$type$name";
        if (!class_exists($class)) {
            throw new CrudException('Invalid vocabulary class');
        }

        return $class;
    }

    /**
     * @Route("/{type}/{name}", name="voc_list", requirements={"type" = "f|o|p|s", "name" = "[\w+-?]+"})
     * @Method({"GET"})
     *
     * @param string $name
     * @param string $type
     *
     * @return JsonResponse
     *
     * @throws CrudException
     */
    public function list(string $name, string $type)
    {
        $repo = $this->getRepository($this->getEntityClass($type, $name));
        $results = $repo
            ->createQueryBuilder('e')
            ->orderBy('e.value')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($results);
    }

    /**
     * @Route("/{type}/{name}/re/{pattern}", name="voc_list", requirements={"type" = "f|o|p|s", "name" = "[\w+-?]+", "pattern" = ".+"})
     * @Method({"GET"})
     *
     * @param string $name
     * @param string $type
     * @param string $pattern
     *
     * @return JsonResponse
     *
     * @throws CrudException
     */
    public function regexp(string $name, string $type, string $pattern)
    {
        $repo = $this->getRepository($this->getEntityClass($type, $name));
        $results = $repo
            ->createQueryBuilder('e')
            ->orderBy('e.value')
            ->where('e.value LIKE :pattern')
            ->setMaxResults(10)
            ->setParameter('pattern', "%$pattern%")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($results);
    }

    /**
     * @Route("/{type}/{name}", name="voc_create", requirements={"type" = "f|o|p|s", "name" = "[\w+-?]+"})
     * @Method({"POST"})
     *
     * @param Request                       $request
     * @param AuthorizationCheckerInterface $authChecker
     * @param string                        $name
     * @param string                        $type
     *
     * @return JsonResponse
     *
     * @throws CrudException
     */
    public function create(Request $request, AuthorizationCheckerInterface $authChecker, string $name, string $type)
    {
        if (!$authChecker->isGranted('voc|create')) {
            return new JsonResponse('Access Denied.', '403');
        }
        $data = json_decode($request->getContent(), true);

        if (is_array($data) && array_key_exists('value', $data)) {
            $class = $this->getEntityClass($type, $name);
            $item = new $class();
            $item->setValue($data['value']);
            $em = $this->doctrine->getManager();
            $em->persist($item);
            try {
                $em->flush();
            } catch (UniqueConstraintViolationException $e)
            {
                $value = $data['value'];
                return new JsonResponse("Duplicate entry \"$value\"", 400);
            }

            return new JsonResponse(['id' => $item->getId(), 'value' => $item->getValue()]);
        } else {
            return new JsonResponse('Invalid request', 400);
        }
    }

    /**
     * @Route("/{type}/{name}/{id}", name="voc_delete", requirements={"type" = "f|o|p|s", "name" = "[\w+-?]+", "id" = "\d+"})
     * @Method({"DELETE"})
     *
     * @param AuthorizationCheckerInterface $authChecker
     * @param string                        $name
     * @param string                        $type
     * @param int                           $id
     *
     * @return JsonResponse
     *
     * @throws CrudException
     */
    public function delete(AuthorizationCheckerInterface $authChecker, string $name, string $type, int $id)
    {
        if (!$authChecker->isGranted('voc|delete')) {
            return new JsonResponse('Access Denied.', '403');
        }

        $repo = $this->getRepository($this->getEntityClass($type, $name));
        $item = $repo->find($id);

        if ($item) {
            $em = $this->doctrine->getManager();
            try {
                $em->remove($item);
                $em->flush();
            } catch (ForeignKeyConstraintViolationException $e) {
                $value = $item->getValue();

                return new JsonResponse("\"$value\" vocabulary value is referenced elsewhere. You cannot delete it", 400);
            }

            return new JsonResponse(['id' => $id, 'value' => $item->getValue()]);
        } else {
            return new JsonResponse("No vocabulary value with id = $id", 404);
        }
    }

    /**
     * @Route("/{type}/{name}/{id}", name="voc_update", requirements={"type" = "f|o|p|s", "name" = "[\w+-?]+", "id" = "\d+"})
     * @Method({"PUT"})
     *
     * @param Request                       $request
     * @param AuthorizationCheckerInterface $authChecker
     * @param string                        $name
     * @param string                        $type
     * @param int                           $id
     *
     * @return JsonResponse
     *
     * @throws CrudException
     */
    public function update(Request $request, AuthorizationCheckerInterface $authChecker, string $name, string $type, int $id)
    {
        if (!$authChecker->isGranted('voc|update')) {
            return new JsonResponse('Access Denied.', '403');
        }

        $repo = $this->getRepository($this->getEntityClass($type, $name));
        $item = $repo->find($id);

        if ($item) {
            $data = json_decode($request->getContent(), true);
            if (is_array($data) && array_key_exists('value', $data)) {
                $em = $this->doctrine->getManager();
                $item->setValue($data['value']);
                $em->persist($item);
                try {
                    $em->flush();
                } catch (UniqueConstraintViolationException $e)
                {
                    $value = $data['value'];
                    return new JsonResponse("Duplicate entry \"$value\"", 400);
                }

                return new JsonResponse(['id' => $item->getId(), 'value' => $item->getValue()]);
            } else {
                return new JsonResponse('Invalid request', 400);
            }
        } else {
            return new JsonResponse("No vocabulary value with id = $id", 404);
        }
    }

    /**
     * @param $entityClass
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository($entityClass)
    {
        return $this->doctrine->getRepository($entityClass);
    }
}
