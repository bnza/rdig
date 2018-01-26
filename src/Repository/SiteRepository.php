<?php

namespace App\Repository;

use App\Entity\Site;
use App\Repository\AbstractDataRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SiteRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Site::class);
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