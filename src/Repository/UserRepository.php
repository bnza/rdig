<?php
/**
 * rDig project.
 *
 * @author pietro.baldassarri@gmail.com
 */

namespace App\Repository;

use App\Entity\User;
use App\Entity\Site;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends AbstractDataRepository
{
    protected function allowedSiteToArray(Site $site, User $user)
    {
        return [
            'id' => sprintf('%d,%d', $user->getId(), $site->getId()),
            'siteId' => $site->getId(),
            'code' => $site->getCode(),
            'name' => $site->getName(),
        ];
    }

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserAllowedSite(int $id, int $siteId)
    {
        $user = $this->find($id);
        if ($user) {
            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('id', $siteId));

            $site = $user->getSites()->matching($criteria)->getValues();
            if (1 === count($site)) {
                return $this->allowedSiteToArray($site[0], $user);
            }
        }
    }

    public function getUserDeniedSites(int $id)
    {
        $user = $this->find($id);
        if ($user) {
            $sites = $user->getSites()->map(function ($site) {
                return $site->getId();
            })->getValues();

            $qb = $this
                ->getEntityManager()
                ->createQueryBuilder();
            $query = $qb->select('s')
                ->from(Site::class, 's')
                ->orderBy('s.name', 'ASC');

            if ($sites) {
                $qb->where($qb->expr()->notIn('s.id', $sites));
            }

            return $query->getQuery()->getArrayResult();
        }
    }
}
