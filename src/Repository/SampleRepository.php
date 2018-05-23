<?php

namespace App\Repository;

use App\Entity\Main\Sample;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;


class SampleRepository extends FindingRepository
{
    protected function getEntityClass(): string
    {
        return Sample::class;
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderLeftJoins($qb);
        $qb->leftJoin('e.type', 'voc__s__type');

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderSelects($qb);
        $qb->addSelect('voc__s__type');

        return $this;
    }

}