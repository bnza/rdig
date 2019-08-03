<?php

namespace App\Repository;

use App\Entity\Main\ObjectEntity;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;


class ObjectRepository extends FindingRepository
{
    protected function getEntityClass(): string
    {
        return ObjectEntity::class;
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderLeftJoins($qb);
        $qb
            ->leftJoin('e.type', 'type')
            ->leftJoin('e.decoration', 'decoration')
            ->leftJoin('e.class', 'class')
            ->leftJoin('e.materialClass', 'materialClass')
            ->leftJoin('e.materialType', 'materialType')
            ->leftJoin('e.technique', 'technique')
            ->leftJoin('e.color', 'color')
            ->leftJoin('e.preservation', 'preservation')
        ;

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderSelects($qb);
        $qb
            ->addSelect('class')
            ->addSelect('decoration')
            ->addSelect('type')
            ->addSelect('materialClass')
            ->addSelect('materialType')
            ->addSelect('technique')
            ->addSelect('color')
            ->addSelect('preservation')
        ;

        return $this;
    }

}
