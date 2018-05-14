<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

abstract class AbstractDataRepository extends ServiceEntityRepository
{
    /**
     * The filter QueryBuilder.
     *
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qbf;
    /**
     * The count QueryBuilder.
     *
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qbc;
    protected $alias = 'e';

    abstract protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository;

    abstract protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository;

    protected function getFilterExpressions(array $filter)
    {
        $expr = null;
        $expressions = [];
        $params = [];
        $i = 1;
        foreach ($filter as $field => $criterium) {
            $le = false === strpos($field, '.')
                ? "{$this->alias}.{$field}"
                : $field;
            $re = "?{$i}";
            // TODO check criterium op
            array_push($expressions, $this->qbf->expr()->{$criterium['op']}($le, $re));
            $params[$i] = $criterium['value'];
            ++$i;
        }
        if (count($expressions) > 1) {
            $expr = $this->qbf->expr()->andX(
                ...$expressions
            );
        } else {
            $expr = $expressions[0];
        }

        return [$expr, $params];
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return QueryBuilder
     */
    protected function createFilterQueryBuilder($limit = null, $offset = null): QueryBuilder
    {
        $this->qbf = $this
            ->createQueryBuilder($this->alias)
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        $this->addQueryBuilderSelects($this->qbf);
        $this->addQueryBuilderLeftJoins($this->qbf);
        return $this->qbf;
    }

    /**
     * @return QueryBuilder
     */
    protected function createCountQueryBuilder(): QueryBuilder
    {
        $this->qbc = $this
            ->createQueryBuilder($this->alias);

        $this->qbc
            ->select($this->qbc->expr()->count($this->alias));

        $this->addQueryBuilderLeftJoins($this->qbc);

        return $this->qbc;
    }

    protected function createQueryBuilders($limit = null, $offset = null)
    {
        $this->createFilterQueryBuilder($limit, $offset);
        $this->createCountQueryBuilder();
    }

    /**
     * @param array $filter
     */
    protected function addFilters(array $filter, ...$params)
    {
        if ($filter) {
            list($expressions, $parameters) = $this->getFilterExpressions($filter);
            // Filter Query
            $this->qbf->add('where', $expressions);
            $this->qbf->setParameters($parameters);
            // Count Query
            $this->qbc->add('where', $expressions);
            $this->qbc->setParameters($parameters);
        }
    }

    protected function addSortCriteria(array $sort)
    {
        if ($sort) {
            $sortCriteria = Criteria::create()
                ->orderBy($sort);
            $this->qbf->addCriteria($sortCriteria);
        }
    }

    protected function getListResultData()
    {
        $queryCount = $this->qbc->getQuery();
        $query = $this->qbf->getQuery();

        return [
            'items' => $query->getArrayResult(),
            'totalItems' => $queryCount->getSingleScalarResult(),
        ];
    }

    public function findByAsArray(array $filter, array $sort, $limit = null, $offset = null)
    {
        $this->createQueryBuilders($limit, $offset);
        $this->addFilters($filter);
        $this->addSortCriteria($sort);

        return $this->getListResultData();
    }

    /**
     * @param int $id
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAsArray(int $id)
    {
        return $this
            ->createFilterQueryBuilder()
            ->add('where', $this->qbf->expr()->eq('e.id','?1'))
            ->setParameter(1, $id)
            ->getQuery()
            ->getSingleResult(Query::HYDRATE_ARRAY);
    }

    public function findByCodeRegExp(string $pattern) {

    }
}
