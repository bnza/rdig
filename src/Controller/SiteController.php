<?php

namespace App\Controller;

use App\Entity\Site;
use App\Service\EntityWrapper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/data")
 */
class SiteController extends Controller
{
    /**
     * Create new site.
     *
     * @param $request
     * @param $validator
     * @param $wrapper
     *
     * @return Response
     *
     * @Route("/site", name="data__site__create")
     * @Method("POST")
     */
    public function create(Request $request, ValidatorInterface $validator, EntityWrapper $wrapper)
    {
        $wrapper->setEntity(Site::class, $request->getContent());

        $errors = $validator->validate($wrapper->entity);
        $response = new JsonResponse();
        if (count($errors) > 0) {
            $response->setData($errors);
        } else {
            try {
                $wrapper->persist();
                $response->setData($wrapper->getData());
                $response->setStatusCode(201);
                $url = $this->generateUrl('data__site__read', array('id' => $wrapper->entity->getId()));
                $response->headers->set('Location', $url);
            } catch (Exception $e) {
                $response->setData($e->getMessage());
            }

            return $response;
        }
    }

    /**
     * @Route("/site", name="data__site__list", requirements={"id" = "\d+"})
     * @Method("GET")
     */
    public function list(Request $request, ValidatorInterface $validator, $id)
    {
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param EntityWrapper $wrapper
     * @param int $id
     * @return JsonResponse
     *
     * @Route("/site/{id}", name="data__site__read", requirements={"id" = "\d+"})
     * @Method("GET")
     */
    public function read(Request $request, ManagerRegistry $doctrine, EntityWrapper $wrapper, $id)
    {
        $product = $doctrine
            ->getRepository(Site::class)
            ->find($id);
        $wrapper->setEntity($product);
        return new JsonResponse($wrapper->getData());
    }

    /**
     * @Route("/site/{id}", name="data__site__replace", requirements={"id" = "\d+"})
     * @Method("PUT")
     */
    public function replace(Request $request, $id, ValidatorInterface $validator)
    {
    }

    /**
     * @Route("/site/{id}", name="data__site__delete", requirements={"id" = "\d+"})
     * @Method("DELETE")
     */
    public function delete(Request $request, $id)
    {
    }
}
