<?php
/**
 * rDig project.
 *
 * @author pietro.baldassarri@gmail.com
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\DataFixtures\UsersFixtures;
use App\Security\SimpleAuthenticator;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class SecurityControllerTest extends WebTestCase
{
    private $application;
    private $output;

    private function dropSchema()
    {
        try {
            $input = new ArrayInput(array(
                'command' => 'doctrine:schema:drop',
                '--force' => true,
            ));

            $this->application->run($input, $this->output);
        } catch (\Exception $e) {

        }
    }

    public function setUp()
    {
        self::bootKernel();
        $this->output = new NullOutput();
        $this->application = new Application(self::$kernel);
        $this->application->setAutoExit(false);

        $this->dropSchema();

        $input = new ArrayInput(array(
            'command' => 'doctrine:database:create',
        ));

        $this->application->run($input, $this->output);

        $input = new ArrayInput(array(
            'command' => 'doctrine:schema:update',
            // (optional) pass options to the command
            '--force' => true,
        ));

        $this->application->run($input, $this->output);

        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $fixtures = new UsersFixtures(self::$kernel->getContainer()->get('security.password_encoder'));
        $fixtures->load($em);
    }

    public function testSuccessfulLogin()
    {
        $client = static::createClient();

        $client->request('POST', '/login', ['username' => 'pippo', 'password' => 'pluto']);

        $response = $client->getResponse();

        $this->assertEquals($response->getStatusCode(), 200);

        $this->assertJsonStringEqualsJsonString(
            json_encode(['username' => 'pippo']),
            $response->getContent()
        );
    }

    public function testFailingNoUser()
    {
        $client = static::createClient();

        $client->request('POST', '/login', ['password' => 'wrong']);

        $response = $client->getResponse();

        $this->assertEquals($response->getStatusCode(), 403);

        $this->assertEquals(SimpleAuthenticator::NO_USERNAME_SUPPLIED,$response->getContent());
    }

    public function testFailingUnknownUser()
    {
        $client = static::createClient();

        $client->request('POST', '/login', ['username' => 'wrong', 'password' => 'wrong']);

        $response = $client->getResponse();

        $this->assertEquals($response->getStatusCode(), 403);

        $this->assertEquals(SimpleAuthenticator::BAD_CREDENTIALS,$response->getContent());
    }

    /**
     * @group wip
     */
    public function testFailingNoPassword()
    {
        $client = static::createClient();

        $client->request('POST', '/login', ['username' => 'pippo']);

        $response = $client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());

        $this->assertEquals(SimpleAuthenticator::NO_PASSWORD_SUPPLIED, $response->getContent());
    }

    public function testFailingWrongPassword()
    {
        $client = static::createClient();

        $client->request('POST', '/login', ['username' => 'pippo', 'password' => 'wrong']);

        $response = $client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());

        $this->assertEquals(SimpleAuthenticator::BAD_CREDENTIALS, $response->getContent());
    }

    public function tearDown()
    {
        $this->dropSchema();
        parent::tearDown();
    }
}
