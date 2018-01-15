<?php

namespace App\Tests\Service;

use App\Service\EntityWrapper;

class EntityWrapperTest extends \PHPUnit_Framework_TestCase
{

    public function testServiceConstructorObjectParameter()
    {

        $entity = new \App\Entity\Site();
        $wrapper = new EntityWrapper($entity);
        $this->assertInstanceOf('\App\Entity\Site', $wrapper->entity);
    }

    public function testServiceConstructorClassNameStringParameter()
    {
        $class = '\App\Entity\Site';
        $wrapper = new EntityWrapper($class);
        $this->assertInstanceOf($class, $wrapper->entity);
    }

    public function testValidJsonData()
    {
        $data = [
            'code' => 'SN',
            'name' => 'Site name'
        ];

        $wrapper = new EntityWrapper('\App\Entity\Site', json_encode($data));
        $data['id'] = null;
        $this->assertEquals($data, $wrapper->getData());
    }

}