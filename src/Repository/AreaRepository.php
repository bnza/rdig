<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 09/03/18
 * Time: 15.23
 */

namespace App\Repository;

use App\Entity\Area;
use App\Repository\AbstractDataRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AreaRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Area::class);
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