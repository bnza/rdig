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
            ->leftJoin('area.site', 'site');

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->addSelect('area')
            ->addSelect('site');

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
            ->addSelect('site')
            ->leftJoin('context.site', 'site')
            ->setMaxResults(10);

        $codes = explode('.', strtoupper($pattern));

        if (0 === count($codes) || count($codes) > 2) {
            return [];
        }

        $siteExpr = $qb->expr()->eq(
            'site.code',
            $qb->expr()->literal($codes[0])
        );

        $contextExpr = $qb->expr()->like(
            'CAST(context.num AS CHAR)',
            $qb->expr()->literal($codes[1] . "%")
        );

        $expr = $qb->expr()->andX(
            $siteExpr,
            $contextExpr
        );

        $qb->add('where', $expr);

        $format = function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['num'],
            ];
        };

        return array_map($format, $qb->getQuery()->getArrayResult());
    }
}
