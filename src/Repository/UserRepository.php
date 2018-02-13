<?php
/**
 * rDig project
 * @author pietro.baldassarri@gmail.com
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends AbstractDataRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserAllowedSites(int $id) {

        $user = $this->find($id);
        if ($user) {
            return $user->getSites()->map(function ($site) use ($user) {
                return [
                    'id' => sprintf('%d,%d', $user->getId(), $site->getId()),
                    'code' => $site->getCode(),
                    'name' => $site->getName()
                ];
            })->getValues();
        }
    }
}