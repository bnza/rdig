<?php

namespace App\Tests\Controller;

use App\Tests\RealDatabaseWorkflowWebTestCase;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//use Doctrine\Common\Persistence\ObjectRepository;

class SiteControllerTest extends RealDatabaseWorkflowWebTestCase
{
    /**
     * @group require_db
     */
    public function testPostValidate()
    {
        $json = '{"code":"SN","name":"Site name"}';

        $client = static::createClient();

        $client->request('POST', '/data/site', [], [], [], $json);

        $response = $client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($json, true);
        $data['id'] = 1;
        $this->assertEquals(
            $data,
            json_decode($response->getContent(), true)
        );

        $this->assertEquals(
            '/data/site/1',
            $response->headers->get('Location')
        );
    }
}
