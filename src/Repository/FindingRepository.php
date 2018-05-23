<?php

namespace App\Repository;

use App\Entity\Main\Finding;
use App\Entity\Main\AbstractFinding;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;


class FindingRepository extends AbstractDataRepository
{
   /* public function __construct(RegistryInterface $registry, string $class = '')
    {
        if (!$class) {
            $class = Finding::class;
        }
        parent::__construct($registry, $class);
    }*/

    protected function getEntityClass(): string
    {
        return Finding::class;
    }

    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->leftJoin('e.bucket', 'bucket')
            ->leftJoin('bucket.context', 'context')
            ->leftJoin('bucket.campaign', 'campaign')
            ->leftJoin('context.area', 'area')
            ->leftJoin('campaign.site', 'site')
            ->leftJoin('e.chronology', 'voc__f__chronology');

        return $this;
    }

    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractDataRepository
    {
        $qb
            ->addSelect('bucket')
            ->addSelect('campaign')
            ->addSelect('context')
            ->addSelect('area')
            ->addSelect('site')
            ->addSelect('voc__f__chronology');

        return $this;
    }

    /**
     * @param AbstractFinding $entity
     * @return bool
     *
     */
    protected function checkConstraints(AbstractFinding $entity)
    {
        // Check bucket-num unique constraint
        $qb = $this
            ->createQueryBuilder($this->alias);
        $qb
            ->add('where', [
                $qb->expr()->andX(
                    $qb->expr()->eq('e.bucket', '?1'),
                    $qb->expr()->eq('e.num', '?1')
                )
            ])
            ->setParameters([
                $entity->getBucket(),
                $entity->getNum()
            ]);

        $uniqueNum = !count($qb->getQuery()->execute());
        return $uniqueNum;
    }

}