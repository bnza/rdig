<?php

namespace App\Repository;

use App\Entity\Main\Pottery;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;


class PotteryRepository extends FindingRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pottery::class);
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderLeftJoins($qb);
        $qb
            ->leftJoin('e.class', 'voc__p__class')
            ->leftJoin('e.coreColor', 'voc__f__core_color')
            ->leftJoin('e.firing', 'voc__p__firing')
            ->leftJoin('e.inclusionsFrequency', 'voc__p__inclusions_frequency')
            ->leftJoin('e.inclusionsSize', 'voc__p__inclusions_size')
            ->leftJoin('e.inclusionsType', 'voc__p__inclusions_type')
            ->leftJoin('e.innerColor', 'voc__f__inner_color')
            ->leftJoin('e.innerDecoration', 'voc__p__inner_decoration')
            ->leftJoin('e.innerSurfaceTreatment', 'voc__p__inner_surface_treatment')
            ->leftJoin('e.outerColor', 'voc__f__outer_color')
            ->leftJoin('e.outerDecoration', 'voc__p__outer_decoration')
            ->leftJoin('e.outerSurfaceTreatment', 'voc__p__outer_surface_treatment')
            ->leftJoin('e.preservation', 'voc__p__preservation')
            ->leftJoin('e.shape', 'voc__p__shape')
            ->leftJoin('e.technique', 'voc__p__technique')
        ;

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        parent::addQueryBuilderSelects($qb);
        $qb
            ->addSelect('voc__p__class')
            ->addSelect('voc__f__core_color')
            ->addSelect('voc__p__firing')
            ->addSelect('voc__p__inclusions_frequency')
            ->addSelect('voc__p__inclusions_size')
            ->addSelect('voc__p__inclusions_type')
            ->addSelect('voc__f__inner_color')
            ->addSelect('voc__p__inner_decoration')
            ->addSelect('voc__p__inner_surface_treatment')
            ->addSelect('voc__f__outer_color')
            ->addSelect('voc__p__outer_decoration')
            ->addSelect('voc__p__outer_surface_treatment')
            ->addSelect('voc__p__preservation')
            ->addSelect('voc__p__shape')
            ->addSelect('voc__p__technique')
        ;

        return $this;
    }

}