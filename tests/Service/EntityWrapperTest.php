<?php

namespace App\Tests\Service;

use App\Service\EntityWrapper;
use Doctrine\Common\Persistence\ObjectManager;

class EntityWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $em;

    public function setUp()
    {
        $this->em = $this->createMock(ObjectManager::class);
    }

    public function testSetEntityMethodEntityObjectParameter()
    {
        $entity = new \App\Entity\Site();
        $wrapper = new EntityWrapper($this->em);
        $wrapper->setEntity($entity);
        $this->assertInstanceOf('\App\Entity\Site', $wrapper->entity);
    }

    public function testSetEntityMethodClassNameStringParameter()
    {
        $class = '\App\Entity\Site';
        $wrapper = new EntityWrapper($this->em);
        $wrapper->setEntity($class);
        $this->assertInstanceOf($class, $wrapper->entity);
    }

    public function testSetEntityMethodWithDataArgument()
    {
        $data = [
            'code' => 'SN',
            'name' => 'Site name',
        ];

        $class = '\App\Entity\Site';
        $wrapper = new EntityWrapper($this->em);
        $wrapper->setEntity($class, $data);
        $this->assertInstanceOf($class, $wrapper->entity);
        $data['id'] = null;
        $this->assertEquals($data, $wrapper->getData());

    }

    public function testSetDataMethodWithValidData()
    {
        $data = [
            'code' => 'SN',
            'name' => 'Site name',
        ];

        $class = '\App\Entity\Site';
        $wrapper = new EntityWrapper($this->em);
        $wrapper->setEntity($class);

        $wrapper->setData($data);

        $data['id'] = null;
        $this->assertEquals($data, $wrapper->getData());
    }
}
