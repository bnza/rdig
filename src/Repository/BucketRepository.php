<?php

namespace App\Repository;

use App\Entity\Bucket;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BucketRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bucket::class);
    }

    protected function createQueryBuilders($limit = null, $offset = null)
    {
        $this
            ->createFilterQueryBuilder($limit, $offset)
            ->addSelect('campaign')
            ->addSelect('context')
            ->addSelect('area')
            ->addSelect('site')
            ->leftJoin('e.context', 'context')
            ->leftJoin('e.campaign', 'campaign')
            ->leftJoin('context.area', 'area')
            ->leftJoin('campaign.site', 'site');
        $this->createCountQueryBuilder()
            ->leftJoin('e.context', 'context')
            ->leftJoin('e.campaign', 'campaign')
            ->leftJoin('context.area', 'area')
            ->leftJoin('campaign.site', 'site');
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