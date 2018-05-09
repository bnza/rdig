<?php

namespace App\Tests\Controller;

use App\Entity\Main\Site;
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

    public function testCreateForbiddenUnauthenticatedUser()
    {
        $json = '{"code":"SN","name":"Site name"}';

        $this->client->request('POST', '/data/site', [], [], [], $json);

        $response = $this->client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());
    }

    /**
     * @group require_db
     */
    public function testCreateValidData()
    {
        $this->login('admin', ['ROLE_ADMIN']);

        $json = '{"code":"SN","name":"Site name"}';

        $this->client->request('POST', '/data/site', [], [], [], $json);

        $response = $this->client->getResponse();

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
        $this->login('admin', ['ROLE_ADMIN']);

        $json = '{"code":"SNC","name":"Site name"}';
        $errorMsg = '{"error":{"violations":[{"property":"code","message":"This value should have exactly 2 characters."}]}}';

        $this->client->request('POST', '/data/site', [], [], [], $json);

        $response = $this->client->getResponse();

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

        $uri = '/data/site/'.$crud->getEntity()->getId();

        $this->client->request('GET', $uri);

        $response = $this->client->getResponse();

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
        $this->login('admin', ['ROLE_ADMIN']);

        $json = '{"code":"SN","name":"Site name"}';

        $validator = $this
            ->getMockBuilder('Symfony\Component\Validator\Validator\TraceableValidator')
            ->disableOriginalConstructor()
            ->getMock();
        $crud = new DataCrudHelper($this->em, $validator);
        $crud
            ->setEntity(Site::class, $json)
            ->persist();

        $this->client->request('POST', '/data/site', [], [], [], $json);

        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $this->assertRegExp('/Duplicate/', $response->getContent());
    }

    public function testUpdateNotFoundEntity()
    {
        $json = '{"id":1,"code":"SN","name":"Site name changed"}';

        $this->client->request('PUT', '/data/site/1', [], [], [], $json);

        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testUpdateForbiddenUnauthenticatedUser()
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

        $this->client->request('PUT', '/data/site/1', [], [], [], $updateJson);

        $response = $this->client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());
    }

    /**
     * @group require_db
     */
    public function testUpdateValidEntity()
    {
        $this->login('admin', ['ROLE_ADMIN']);

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

        $this->client->request('PUT', '/data/site/1', [], [], [], $updateJson);

        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @group require_db
     */
    public function testUpdateDuplicateUniqueSiteCode()
    {
        $this->login('admin', ['ROLE_ADMIN']);

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

        $this->client->request('PUT', '/data/site/1', [], [], [], $updateJson);

        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDeleteNotFoundEntity()
    {
        $this->client->request('DELETE', '/data/site/1');

        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteForbiddenUnauthenticatedUser()
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

        $this->client->request('DELETE', '/data/site/1');

        $response = $this->client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());
    }

    /**
     * @group require_db
     */
    public function testDeleteExistentEntity()
    {
        $this->login('admin', ['ROLE_ADMIN']);

        $json = '{"code":"SN","name":"Site name"}';

        $validator = $this
            ->getMockBuilder('Symfony\Component\Validator\Validator\TraceableValidator')
            ->disableOriginalConstructor()
            ->getMock();

        $crud = new DataCrudHelper($this->em, $validator);
        $crud
            ->setEntity(Site::class, $json)
            ->persist();

        $this->client->request('DELETE', '/data/site/1');

        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
