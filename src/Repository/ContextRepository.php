<?php

namespace App\Repository;

use App\Entity\Context;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContextRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Context::class);
    }

    protected function createQueryBuilders($limit = null, $offset = null)
    {
        $this
            ->createFilterQueryBuilder($limit, $offset)
            ->addSelect('area')
            ->addSelect('site')
            ->leftJoin('e.area', 'area')
            ->leftJoin('area.site', 'site');
        $this->createCountQueryBuilder()
            ->leftJoin('e.area', 'area')
            ->leftJoin('area.site', 'site');
    }

    public function getMaxSiteContextNum(int $siteId): int
    {
        $qb = $this
            ->createQueryBuilder('e')
            ->select('MAX(e.num) AS maxNum');
        $qb
            ->where(
                $qb->expr()->eq('e.site', $qb->expr()->literal($siteId))
            );

        $num = $qb->getQuery()->getSingleScalarResult();

        return $num ? $num : 0;
    }
}
