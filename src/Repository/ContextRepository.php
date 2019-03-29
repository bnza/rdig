<?php

namespace App\Repository;

use App\Entity\Main\Context;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContextRepository extends AbstractDataRepository
{

    protected function getEntityClass(): string
    {
        return Context::class;
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->leftJoin('e.area', 'area')
            ->leftJoin('area.site', 'site')
            ->leftJoin('e.chronology', 'chronology');

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->addSelect('area')
            ->addSelect('site')
            ->addSelect('chronology');

        return $this;
    }

/*    protected function createQueryBuilders($limit = null, $offset = null)
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
    }*/

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

    public function findByCodeRegExp(string $pattern) {
        $qb = $this
            ->createQueryBuilder('context')
            ->addSelect('area')
            ->addSelect('site')
            ->leftJoin('context.area', 'area')
            ->leftJoin('area.site', 'site')
            ->setMaxResults(10);

        $codes = explode('.', strtoupper($pattern));

        if (0 === count($codes) || count($codes) > 2) {
            return [];
        }

        if (strlen($codes[0]) === 1) {
            $siteExpr = $qb->expr()->like(
                'site.code',
                $qb->expr()->literal(strtoupper($codes[0]) . "%")
            );
        } else if (strlen($codes[0]) === 2) {
            $siteExpr = $qb->expr()->eq(
                'site.code',
                $qb->expr()->literal(strtoupper($codes[0]))
            );
        } else {
            throw new \InvalidArgumentException('Invalid site code length '. $codes[0]);
        }


        if (isset($codes[1])) {
            $contextExpr = $qb->expr()->like(
                'CAST(context.num AS CHAR)',
                $qb->expr()->literal($codes[1] . "%")
            );
            $expr = $qb->expr()->andX(
                $siteExpr,
                $contextExpr
            );
        } else {
            $expr = $siteExpr;
        }




        $qb->add('where', $expr);

/*        $format = function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['num'],
            ];
        };

        return array_map($format, $qb->getQuery()->getArrayResult());*/
        return $qb->getQuery()->getArrayResult();
    }
}
