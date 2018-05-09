<?php

namespace App\Repository;

use App\Entity\Main\Campaign;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CampaignRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Campaign::class);
    }

    protected function createQueryBuilders($limit = null, $offset = null)
    {
        $this
            ->createFilterQueryBuilder($limit, $offset)
            ->addSelect('site')
            ->leftJoin('e.site', 'site');
        $this->createCountQueryBuilder()
            ->leftJoin('e.site', 'site');
    }

    public function findByCodeRegExp(string $pattern) {
        $qb = $this
            ->createQueryBuilder('campaign')
            ->addSelect('site')
            ->leftJoin('campaign.site', 'site')
            ->setMaxResults(10);
        $codes = explode('.', strtoupper($pattern));

        if (0 === count($codes) || count($codes) > 2) {
            return [];
        }

        $expr = [];

        if (is_int($codes[0])) {

        } else {
            switch (strlen($codes[0])) {
                case 1:
                    $siteExprOp = 'like';
                    $siteExprValue = $qb->expr()->literal($codes[0].'%');
                    break;
                case 2:
                    $siteExprOp = 'eq';
                    $siteExprValue = $qb->expr()->literal($codes[0]);
                    break;
                default:
                    return [];
            }
            $expr[] = $qb->expr()->{$siteExprOp}('site.code', $siteExprValue);
        }

        if (2 === count($codes)) {
            if (strlen((string)$codes[1]) === 4) {
                $expr[] = $qb->expr()->eq(
                    'campaign.year',
                    $qb->expr()->literal($codes[1])
                );
            } else {
                $qb->expr()->like(
                    'CAST(campaign.year AS CHAR)',
                    $qb->expr()->literal($codes[1] . "%")
                );
            }

            $expr = $qb->expr()->andX(
                ...$expr
            );
        }

        $qb->add('where', $expr);

        $format = function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['site']['code'].'.'.$item['year'],
            ];
        };

        return array_map($format, $qb->getQuery()->getArrayResult());

    }

}