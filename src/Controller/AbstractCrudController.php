<?php

namespace App\Controller;

use App\Exceptions\NotFoundCrudException;
use App\Service\DataCrudHelper;
use App\Service\EntityWrapper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractCrudController extends Controller
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
}
