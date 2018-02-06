<?php

namespace App\Tests;

use App\Tests\DataFixtures\UsersFixtures;
use App\Tests\Traits\RealDatabaseWorkflowTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;


abstract class RealDatabaseWorkflowWebTestCase extends WebTestCase
{

    use RealDatabaseWorkflowTrait;

    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        $this->_setUp();
        $this->client = static::createClient();
    }

    public function tearDown()
    {
        $this->_tearDown();
    }

    public function loadUsers() {
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $fixtures = new UsersFixtures(self::$kernel->getContainer()->get('security.password_encoder'));
        $fixtures->load($em);
    }

    public function login(string $username, $roles)
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken($username, null, $firewallContext, $roles);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
