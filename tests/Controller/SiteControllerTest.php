<?php

namespace App\Tests\Controller;

use App\Entity\Site;
use App\Service\EntityWrapper;
use App\Tests\RealDatabaseWorkflowWebTestCase;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//use Doctrine\Common\Persistence\ObjectRepository;

class SiteControllerTest extends RealDatabaseWorkflowWebTestCase
{
    /**
     * @param string $json
     * @param $id
     * @return mixed
     */
    protected function stubEntityArray($json, $id) {
        $data = json_decode($json, true);
        $data['id'] = $id;
        return $data;
    }

    /**
     * @group require_db
     */
    public function testCreateValidate()
    {
        $json = '{"code":"SN","name":"Site name"}';

        $client = static::createClient();

        $client->request('POST', '/data/site', [], [], [], $json);

        $response = $client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());

        $data = $this->stubEntityArray($json, 1);

        $this->assertEquals(
            $data,
            json_decode($response->getContent(), true)
        );

        $this->assertEquals(
            '/data/site/1',
            $response->headers->get('Location')
        );
    }

    /**
     * @group require_db
     */
    public function testReadValidEntity()
    {
        $json = '{"code":"SN","name":"Site name"}';

        $wrapper = new EntityWrapper($this->em);
        $wrapper
            ->setEntity(Site::class, $json)
            ->persist();

        $client = static::createClient();

        $uri = '/data/site/'.$wrapper->entity->getId();

        $client->request('GET', $uri);

        $response = $client->getResponse();

        $data = $this->stubEntityArray($json, 1);

        $this->assertEquals(
            $data,
            json_decode($response->getContent(), true)
        );
    }
}
