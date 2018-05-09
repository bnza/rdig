<?php
/**
 * rDig project
 * @author pietro.baldassarri@gmail.com
 */

namespace App\Tests\DataFixtures;

use App\Entity\Main\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UsersFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface
{
    private  $encoder;

    private $container;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'username' => 'admin',
                'password' => 'admin_pw',
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'username' => 'pippo',
                'password' => 'pluto',
                'roles' => ['ROLE_USER']
            ]
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);

            $password = $this->encoder->encodePassword($user, $userData['password']);
            $user->setPassword($password);

            $user->setRoles($userData['roles']);

            $manager->persist($user);
            $manager->flush();
        }
    }
}