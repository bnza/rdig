<?php

namespace App\Repository;

use App\Entity\Site;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\UnitOfWork;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class AbstractDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Site::class);
    }

    public function findByAsArray(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {

        $qb = $this
            ->createQueryBuilder('e')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit );

        $query = $qb->getQuery();

        return $query->getArrayResult();
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}