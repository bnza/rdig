<?php

namespace App\Tests\Controller;

use App\Entity\Site;
use App\Service\EntityWrapper;
use App\Service\DataCRUDHelper;
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
    public function testCreateValidData()
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
    public function testCreateInvalidCodeData()
    {
        $json = '{"code":"SNC","name":"Site name"}';
        $errorMsg = '{"error":[{"violations":[{"property":"code","message":"This value should have exactly 2 characters."}]}]}';

        $client = static::createClient();

        $client->request('POST', '/data/site', [], [], [], $json);

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            $errorMsg,
            $response->getContent()
        );
    }

    /**
     * @group require_db
     */
    public function testReadValidEntity()
    {
        $json = '{"code":"SN","name":"Site name"}';

        $validator = $this
            ->getMockBuilder('Symfony\Component\Validator\Validator\TraceableValidator')
            ->disableOriginalConstructor()
            ->getMock();
        $crud = new DataCRUDHelper($this->em, $validator);
        $crud
            ->setEntity(Site::class, $json)
            ->persist();

        $client = static::createClient();

        $uri = '/data/site/'.$crud->getEntity()->getId();

        $client->request('GET', $uri);

        $response = $client->getResponse();

        $data = $this->stubEntityArray($json, 1);

        $this->assertEquals(
            $data,
            json_decode($response->getContent(), true)
        );
    }

    /**
     * @group require_db
     */
    public function testDuplicateKeyEntity()
    {
        $json = '{"code":"SN","name":"Site name"}';

        $validator = $this
            ->getMockBuilder('Symfony\Component\Validator\Validator\TraceableValidator')
            ->disableOriginalConstructor()
            ->getMock();
        $crud = new DataCRUDHelper($this->em, $validator);
        $crud
            ->setEntity(Site::class, $json)
            ->persist();

        $client = static::createClient();

        $client->request('POST', '/data/site', [], [], [], $json);

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $this->assertRegExp('/Duplicate/', $response->getContent());
    }
}
