<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;

abstract class AbstractDataRepository extends ServiceEntityRepository
{
    public function findByAsArray(array $filter, array $sort, array $where, $limit = null, $offset = null)
    {
        $qb = $this
            ->createQueryBuilder('e')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $qbCount = $this
            ->createQueryBuilder('e');
        $qbCount
            ->select($qbCount->expr()->count('e'));

        if ($where) {
            $whereCriteria = Criteria::create()
                ->orderBy($sort);
            $qb->addCriteria($whereCriteria);
            $qbCount->addCriteria($whereCriteria);
        }

        if ($sort) {
            $sortCriteria = Criteria::create()
                ->orderBy($sort);
            $qb->addCriteria($sortCriteria);
        }

        $queryCount = $qbCount->getQuery();

        $query = $qb->getQuery();

        return [
            'items' => $query->getArrayResult(),
            'totalItems' => $queryCount->getSingleScalarResult(),
        ];
    }
}
