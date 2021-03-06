<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 09/03/18
 * Time: 15.23.
 */

namespace App\Repository;

use App\Entity\Main\Area;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Collections\Criteria;

class AreaRepository extends AbstractDataRepository
{
    protected function getEntityClass(): string
    {
        return Area::class;
    }

    protected function getSiteCodeAlias(): string
    {
        return 'site.code';
    }

    protected function addSiteFilter(string $code): AbstractDataRepository
    {
        $criteria = $this->qbf->expr()->eq('site.code', ':siteCodeFilter');
        $this->qbf->addCriteria($criteria)->setParameter(':siteCodeFilter', $code);
        $this->qbc->addCriteria($criteria)->setParameter(':siteCodeFilter', $code);
        return $this;
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        $qb->leftJoin('e.site', 'site');
        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->addSelect('site');

        return $this;
    }

    /**
     * @param string $pattern
     * @return array
     * @throws \Exception
     */
    public function findByCodeRegExp(string $pattern)
    {
        $qb = $this
            ->createQueryBuilder('area')
            ->addSelect('site')
            ->leftJoin('area.site', 'site')
            ->setMaxResults(10);
        $codes = explode('.', strtoupper($pattern));

        if (0 === count($codes) || count($codes) > 2) {
            throw new \Exception("Invalid pattern \"$pattern\"");
        }

        $expr = [];

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
                throw new \Exception("Invalid pattern \"$pattern\"");
        }
        $expr[] = $qb->expr()->{$siteExprOp}('site.code', $siteExprValue);

        if (2 === count($codes)) {
            if (strlen($codes[1]) > 3) {
                throw new \Exception("Invalid pattern \"$pattern\"");
            }
            $expr[] = $qb->expr()->like(
                'area.code',
                $qb->expr()->literal($codes[1].'%')
            );
            $expr = $qb->expr()->andX(
                ...$expr
            );
        }

        $qb->add('where', $expr);

/*        $format = function ($item) {
            return [
              'id' => $item['id'],
                'name' => $item['site']['code'].'.'.$item['code'],
            ];
        };

        return array_map($format, $qb->getQuery()->getArrayResult());*/
        return $qb->getQuery()->getArrayResult();
    }
}
