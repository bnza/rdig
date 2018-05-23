<?php

namespace App\Repository;

use App\Entity\Main\Pottery;
use Doctrine\ORM\QueryBuilder;


class PotteryRepository extends FindingRepository
{
    protected function getEntityClass(): string
    {
        return Pottery::class;
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderLeftJoins($qb);
        $qb
            ->leftJoin('e.class', 'class')
            ->leftJoin('e.coreColor', 'coreColor')
            ->leftJoin('e.firing', 'firing')
            ->leftJoin('e.inclusionsFrequency', ' inclusionsFrequency')
            ->leftJoin('e.inclusionsSize', 'inclusionsSize')
            ->leftJoin('e.inclusionsType', 'inclusionsType')
            ->leftJoin('e.innerColor', 'innerColor')
            ->leftJoin('e.innerDecoration', 'innerDecoration')
            ->leftJoin('e.innerSurfaceTreatment', 'innerSurfaceTreatment')
            ->leftJoin('e.outerColor', 'outerColor')
            ->leftJoin('e.outerDecoration', 'outerDecoration')
            ->leftJoin('e.outerSurfaceTreatment', 'outerSurfaceTreatment')
            ->leftJoin('e.preservation', 'preservation')
            ->leftJoin('e.shape', 'shape')
            ->leftJoin('e.technique', 'technique')
        ;

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderSelects($qb);
        $qb
            ->addSelect('class')
            ->addSelect('coreColor')
            ->addSelect('firing')
            ->addSelect('inclusionsFrequency')
            ->addSelect('inclusionsSize')
            ->addSelect('inclusionsType')
            ->addSelect('innerColor')
            ->addSelect('innerDecoration')
            ->addSelect('innerSurfaceTreatment')
            ->addSelect('outerColor')
            ->addSelect('outerDecoration')
            ->addSelect('outerSurfaceTreatment')
            ->addSelect('preservation')
            ->addSelect('shape')
            ->addSelect('technique')
        ;

        return $this;
    }

}