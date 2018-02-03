<?php

namespace App\Tests\Controller;

use App\Entity\Site;
use App\Service\DataCrudHelper;
use App\Tests\RealDatabaseWorkflowWebTestCase;

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
        $errorMsg = '{"error":{"violations":[{"property":"code","message":"This value should have exactly 2 characters."}]}}';
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
        $crud = new DataCrudHelper($this->em, $validator);
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
        $crud = new DataCrudHelper($this->em, $validator);
        $crud
            ->setEntity(Site::class, $json)
            ->persist();

        $client = static::createClient();

        $client->request('POST', '/data/site', [], [], [], $json);

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $this->assertRegExp('/Duplicate/', $response->getContent());
    }

    /**
     * @group require_db
     */
    public function testUpdateValidEntity()
    {
        $json = '{"code":"SN","name":"Site name"}';
        $updateJson = '{"id":1,"code":"SN","name":"Site name changed"}';

        $validator = $this
            ->getMockBuilder('Symfony\Component\Validator\Validator\TraceableValidator')
            ->disableOriginalConstructor()
            ->getMock();
        $crud = new DataCrudHelper($this->em, $validator);
        $crud
            ->setEntity(Site::class, $json)
            ->persist();

        $client = static::createClient();

        $client->request('PUT', '/data/site/1', [], [], [], $updateJson);

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @group require_db
     */
    public function testUpdateDuplicateUniqueSiteCode()
    {
        $json = '{"code":"S1","name":"Site name 1"}';
        $json2 = '{"code":"S2","name":"Site name 2"}';
        $updateJson = '{"id":2,"code":"S1","name":"Site name changed"}';

        $validator = $this
            ->getMockBuilder('Symfony\Component\Validator\Validator\TraceableValidator')
            ->disableOriginalConstructor()
            ->getMock();
        $crud = new DataCrudHelper($this->em, $validator);
        $crud
            ->setEntity(Site::class, $json)
            ->persist();
        $crud
            ->setEntity(Site::class, $json2)
            ->persist();

        $client = static::createClient();

        $client->request('PUT', '/data/site/1', [], [], [], $updateJson);

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @group require_db
     */
    public function testDeleteExistentEntity()
    {
        $json = '{"code":"SN","name":"Site name"}';

        $validator = $this
            ->getMockBuilder('Symfony\Component\Validator\Validator\TraceableValidator')
            ->disableOriginalConstructor()
            ->getMock();

        $crud = new DataCrudHelper($this->em, $validator);
        $crud
            ->setEntity(Site::class, $json)
            ->persist();

        $client = static::createClient();

        $client->request('DELETE', '/data/site/1');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}