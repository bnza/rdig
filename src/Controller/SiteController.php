<?php

namespace App\Controller;

use App\Entity\Site;
use App\Service\EntityWrapper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/data")
 */
class SiteController extends Controller
{
    public function persist($entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }

    /**
     * Create new site.
     *
     * @Route("/site", name="data__site__new")
     * @Method("POST")
     */
    public function post(Request $request, ValidatorInterface $validator)
    {
        $wrapper = new EntityWrapper(Site::class, $request->getContent());

        $errors = $validator->validate($wrapper->entity);
        $response = new JsonResponse();
        if (count($errors) > 0) {
            $response->setData($errors);
        } else {
            try {
                $this->persist($wrapper->entity);
                $response->setData($wrapper->getData());
                $response->setStatusCode(201);
                $url = $this->generateUrl('data__site__get', array('id' => $wrapper->entity->getId()));
                $response->headers->set('Location', $url);
            } catch (Exception $e) {
                $response.setData($e->getMessage());
            }
            return $response;
        }
    }

    /**
     * @Route("/site", name="data__sites__get", requirements={"id" = "\d+"})
     * @Method("GET")
     */
    public function getAll(Request $request, $id, ValidatorInterface $validator)
    {
    }

    /**
     * @Route("/site/{id}", name="data__site__get", requirements={"id" = "\d+"})
     * @Method("GET")
     */
    public function new(Request $request, $id, ValidatorInterface $validator)
    {
    }

    /**
     * @Route("/site/{id}", name="data__site__put", requirements={"id" = "\d+"})
     * @Method("PUT")
     */
    public function put(Request $request, $id, ValidatorInterface $validator)
    {
    }

    /**
     * @Route("/site/{id}", name="data__site__delete", requirements={"id" = "\d+"})
     * @Method("DELETE")
     */
    public function delete(Request $request, $id, ValidatorInterface $validator)
    {
    }
}
