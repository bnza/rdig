<?php

namespace App\Repository;

use App\Service\SiteFilter;
use Symfony\Bridge\Doctrine\RegistryInterface;
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

    /**
     * @var string
     */
    protected $alias = 'e';

    /**
     * @var SiteFilter
     */
    protected $siteFilter;

    public function __construct(RegistryInterface $registry, SiteFilter $siteFilter)
    {
        parent::__construct($registry, $this->getEntityClass());
        $this->siteFilter = $siteFilter;
    }

    /**
     * Called by service constructor
     * @see config/service.yaml
     *
     * @param SiteFilter $siteFilter
     */
    public function setSiteFilter(SiteFilter $siteFilter)
    {
        $this->siteFilter = $siteFilter;
    }

    abstract protected function getEntityClass(): string;

    protected function getSiteCodeAlias(): string
    {
        return 'site.code';
    }

    abstract protected function addQueryBuilderLeftJoins(QueryBuilder $qb): self;

    abstract protected function addQueryBuilderSelects(QueryBuilder $qb): self;

    protected function getFilterExpressions(array $filter)
    {
        $expr = null;
        $expressions = [];
        $params = [];
        $i = 1;
        $noOperandOps = [
          'isNull',
          'isNotNull',
        ];
        foreach ($filter as $field => $criterium) {
            // LEFT EXPRESSION: field alias
            $le = false === strpos($field, '.')
                ? "{$this->alias}.{$field}"
                : $field;
            // RIGHT OPERAND: value parameter
            $re = ":p{$i}";
            // TODO check criterium op
            array_push($expressions, $this->qbf->expr()->{$criterium['op']}($le, $re));

            if (!in_array($criterium['op'], $noOperandOps)) {
                if (array_key_exists('cast', $criterium)) {
                    switch ($criterium['cast']) {
                    case 'bool':
                        $param = false == $criterium['value'] || 'false' === $criterium['value'] ? false : true;
                        break;
                    default:
                        $param = $criterium['value'];
                }
                } else {
                    $param = $criterium['value'];
                }
                $params[":p{$i}"] = $param;
            }
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
     *
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
        // Ad general site filter
        $sfc = $this->siteFilter->getSiteCode();
        if ($sfc) {
            $siteCodeAlias = $this->getSiteCodeAlias();
            if ($siteCodeAlias) {
                $expr = $this->qbf->expr()->eq($siteCodeAlias, ':siteCodeFilter');
                $this->qbf->add('where', $expr)->setParameter(':siteCodeFilter', $sfc);
                $this->qbc->add('where', $expr)->setParameter(':siteCodeFilter', $sfc);
            }
        }

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
     * @param array $filter
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getFilterQueryCount(array $filter): int
    {
        $this->createQueryBuilders([], 0);
        $this->addFilters($filter);
        return $this->qbc->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAsArray(int $id)
    {
        return $this
            ->createFilterQueryBuilder()
            ->add('where', $this->qbf->expr()->eq('e.id', '?1'))
            ->setParameter(1, $id)
            ->getQuery()
            ->getSingleResult(Query::HYDRATE_ARRAY);
    }

    public function findByCodeRegExp(string $pattern)
    {
        // TODO throw LogicException or make method abstract
    }
}
