<?php

namespace App\Repository;

use App\Entity\Main\Object;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;


class ObjectRepository extends FindingRepository
{
    protected function getEntityClass(): string
    {
        return Object::class;
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderLeftJoins($qb);
        $qb
            ->leftJoin('e.type', 'voc__o__type')
            ->leftJoin('e.decoration', 'voc__o__decoration')
            ->leftJoin('e.class', 'voc__o__class')
            ->leftJoin('e.materialClass', 'voc__o__material_class')
            ->leftJoin('e.materialType', 'voc__o__material_type')
            ->leftJoin('e.technique', 'voc__o__technique')
            ->leftJoin('e.color', 'voc__f__color')
            ->leftJoin('e.preservation', 'voc__o__preservation')
        ;

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderSelects($qb);
        $qb
            ->addSelect('voc__o__class')
            ->addSelect('voc__o__decoration')
            ->addSelect('voc__o__type')
            ->addSelect('voc__o__material_class')
            ->addSelect('voc__o__material_type')
            ->addSelect('voc__o__technique')
            ->addSelect('voc__f__color')
            ->addSelect('voc__o__preservation')
        ;

        return $this;
    }

}