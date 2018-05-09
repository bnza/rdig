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
        $entity = new \App\Entity\Main\Site();
        $wrapper = new EntityWrapper($this->em);
        $wrapper->setEntity($entity);
        $this->assertInstanceOf('\App\Entity\Main\Site', $wrapper->getEntity());
    }

    public function testSetEntityMethodClassNameStringParameter()
    {
        $class = '\App\Entity\Main\Site';
        $wrapper = new EntityWrapper($this->em);
        $wrapper->setEntity($class);
        $this->assertInstanceOf($class, $wrapper->getEntity());
    }

    public function testSetEntityMethodWithDataArgument()
    {
        $data = [
            'code' => 'SN',
            'name' => 'Site name',
        ];

        $class = '\App\Entity\Main\Site';
        $wrapper = new EntityWrapper($this->em);
        $wrapper->setEntity($class, $data);
        $this->assertInstanceOf($class, $wrapper->getEntity());
        $data['id'] = null;
        $this->assertEquals($data, $wrapper->getData());

    }

    public function testSetDataMethodWithValidData()
    {
        $data = [
            'code' => 'SN',
            'name' => 'Site name',
        ];

        $class = '\App\Entity\Main\Site';
        $wrapper = new EntityWrapper($this->em);
        $wrapper->setEntity($class);

        $wrapper->setData($data);

        $data['id'] = null;
        $this->assertEquals($data, $wrapper->getData());
    }
}
