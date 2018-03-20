<?php

namespace App\Repository;

use App\Entity\Campaign;
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

}