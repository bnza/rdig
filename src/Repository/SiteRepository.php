<?php

namespace App\Repository;

use App\Entity\Main\Site;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\ORMException;

class SiteRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Site::class);
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        return $this;
    }

    protected function addUserAllowedFilters(array $filter, ...$params)
    {
        $filter['u.id'] = ['op' => 'eq', 'value' => $params[0]];
        parent::addFilters($filter);
    }

    protected function addJoins()
    {
        $this->qbf->innerJoin('e.users', 'u');
        $this->qbc->innerJoin('e.users', 'u');
    }

    public function getUserAllowedSites(int $id, array $filter, array $sort, $limit = null, $offset = null)
    {
        $this->createQueryBuilders($limit, $offset);
        $this->addJoins();
        $this->addUserAllowedFilters($filter, $id);
        $this->addSortCriteria($sort);

        return $this->getListResultData();
    }

    /**
     * @param string $code
     * @return bool|Site
     */
    public function findByCode(string $code)
    {
        try {
            $site = parent::findByCode($code);
            return count($site) ? $site[0] : $site;
        } catch (ORMException $e) {
            return false;
        }
    }
}
