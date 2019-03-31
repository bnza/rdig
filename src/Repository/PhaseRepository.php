<?php

namespace App\Repository;

use App\Entity\Main\Phase;
use Doctrine\ORM\QueryBuilder;

class PhaseRepository extends AbstractDataRepository
{
    protected function getEntityClass(): string
    {
        return Phase::class;
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

    public function findByCodeRegExp(string $pattern)
    {
        $qb = $this
            ->createQueryBuilder('phase')
            ->addSelect('site')
            ->leftJoin('phase.site', 'site')
            ->setMaxResults(10);
        list($siteCode, $phasePattern) = explode('.', strtoupper($pattern));

        $expression = $qb->expr()->eq('site.code', $qb->expr()->literal($siteCode));

        if ($phasePattern) {
            $expressions = [];
            $expressions[] = $expression;
            $expressions[] = $qb->expr()->like(
                'phase.name',
                $qb->expr()->literal("%$phasePattern%")
            );
            $expression = $qb->expr()->andX(
                ...$expressions
            );
        }

        $qb->add('where', $expression);

        return $qb->getQuery()->getArrayResult();
    }
}
