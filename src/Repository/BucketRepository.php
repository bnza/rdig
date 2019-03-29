<?php

namespace App\Repository;

use App\Entity\Main\Bucket;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Collections\Criteria;

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

    public function getByCodePattern(string $subject): array
    {
        //$pattern = '/([[:alpha:]]{1,2})(\d{0,2})P?(\d{0,3}\w{0,1})/';
        // match KH.11.004e
        $pattern = '/([[:alpha:]]{1,2})\.?(\d{0,2})\.?(\d{0,3}\w{0,1})/';
        preg_match($pattern, $subject, $matches);
        if ($matches) {
            $expr = [];
            $params = [];
            list($code,$site,$year,$bucket) = $matches;
            $this->createFilterQueryBuilder(10,0);

            $siteExprOp = strlen($site) === 2 ? 'eq' : 'like';
            $params['site'] = strlen($site) === 2 ? strtoupper($site) : "${site}_";
            $expr[] = $this->qbf->expr()->{$siteExprOp}('site.code', ':site');

            if ($year) {
                $yearExprOp = strlen($year) === 2 ? 'eq' : 'like';
                $params['year']  = strlen($year) === 2 ? "20${year}" : "20${year}_";
                $expr[] = $this->qbf->expr()->{$yearExprOp}('campaign.year', ':year');
            }

            if ($bucket) {
                $bucketExprOp = strlen($bucket) === 4 ? 'eq' : 'like';
                $params['bucket'] = strlen($bucket) === 4 ? $bucket : "%${bucket}%";
                $expr[] = $this->qbf->expr()->{$bucketExprOp}('e.num', ':bucket');
            }

            $expr = $this->qbf->expr()->andX(
                ...$expr
            );

            $this->qbf
                ->add('where', $expr)
                ->setParameters($params);
            $this->qbf
                ->orderBy('site.code')
                ->addOrderBy('campaign.year')
                ->addOrderBy('e.num');

            $results = $this->qbf->getQuery()->getArrayResult();

            $generateCode = function($item) {
                //$item['code'] = $item['campaign']['site']['code'].substr($item['campaign']['year'],2).'P'.$item['num'];
                $item['code'] = $item['campaign']['site']['code'].'.'.substr($item['campaign']['year'],2).'.'.$item['num'];
                return $item;
            };

            return array_map($generateCode, $results);
        }
    }


}
