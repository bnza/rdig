<?php

namespace App\Repository;

use App\Entity\Main\Finding;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;


class FindingRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry, string $class = '')
    {
        if (!$class) {
            $class = Finding::class;
        }
        parent::__construct($registry, $class);
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->leftJoin('e.bucket', 'bucket')
            ->leftJoin('bucket.context', 'context')
            ->leftJoin('bucket.campaign', 'campaign')
            ->leftJoin('context.area', 'area')
            ->leftJoin('campaign.site', 'site')
            ->leftJoin('e.chronology', 'voc__f__chronology');

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->addSelect('bucket')
            ->addSelect('campaign')
            ->addSelect('context')
            ->addSelect('area')
            ->addSelect('site')
            ->addSelect('voc__f__chronology');

        return $this;
    }

}