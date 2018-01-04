<?php
/**
 * rDig project
 * @author pietro.baldassarri@gmail.com
 */

namespace App\Tests\DataFixtures;

use App\Entity\User;
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
        $user = new User();
        $user->setUsername('pippo');

        $password = $this->encoder->encodePassword($user, 'pluto');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}