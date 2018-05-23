<?php

namespace App\Repository;

use App\Entity\Main\Bucket;
use Doctrine\ORM\QueryBuilder;

class BucketRepository extends AbstractDataRepository
{
    protected function getEntityClass(): string
    {
        return Bucket::class;
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->leftJoin('e.context', 'context')
            ->leftJoin('e.campaign', 'campaign')
            ->leftJoin('context.area', 'area')
            ->leftJoin('campaign.site', 'site');

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->addSelect('campaign')
            ->addSelect('context')
            ->addSelect('area')
            ->addSelect('site');

        return $this;
    }

    /**
     * @param int $campaignId
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMaxCampaignBucketNum(int $campaignId): int
    {
        $qb = $this
            ->createQueryBuilder('e')
            ->select('MAX(e.num) AS maxNum');
        $qb
            ->where(
                $qb->expr()->eq('e.campaign', $qb->expr()->literal($campaignId))
            );

        $num = $qb->getQuery()->getSingleScalarResult();

        return $num ? $num : 0;
    }


}