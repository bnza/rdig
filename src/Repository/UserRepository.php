<?php
/**
 * rDig project.
 *
 * @author pietro.baldassarri@gmail.com
 */

namespace App\Repository;

use App\Entity\User;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserAllowedSites(int $id)
    {
        $user = $this->find($id);
        if ($user) {
            return $user->getSites()->map(function ($site) use ($user) {
                return [
                    'id' => sprintf('%d,%d', $user->getId(), $site->getId()),
                    'code' => $site->getCode(),
                    'name' => $site->getName(),
                ];
            })->getValues();
        }
    }

    public function getUserDeniedSites(int $id)
    {
        $user = $this->find($id);
         if ($user) {
             $sites = $user->getSites()->map(function ($site) {
                return $site->getId();
            })->getValues();
        }
        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder();
        $query = $qb->select('s')
            ->from(Site::class, 's')
            ->where($qb->expr()->notIn('s.id', $sites) )
            ->orderBy('s.name', 'ASC')
            ->getQuery();
         return $query->getArrayResult();
    }
}
