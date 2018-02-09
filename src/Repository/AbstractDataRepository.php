<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;

abstract class AbstractDataRepository extends ServiceEntityRepository
{

    public function findByAsArray(array $filter, array $sort, $limit = null, $offset = null)
    {

        $qb = $this
            ->createQueryBuilder('e')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit );

        if ($sort) {
            $sortCriteria = Criteria::create()
                ->orderBy($sort);
            $qb->addCriteria($sortCriteria);
        }

        $query = $qb->getQuery();

        return $query->getArrayResult();
    }
}