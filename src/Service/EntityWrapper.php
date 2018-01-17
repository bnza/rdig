<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util;
use Doctrine\ORM\Mapping\Entity;

class EntityWrapper
{
    /**
     * @var ObjectManager
     */
    protected $em;
    public $entity;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string|Entity $entity
     * @param array $data
     * @return $this
     */
    public function setEntity($entity, $data = null)
    {
        if (is_string($entity) && class_exists($entity)) {
            $entity = new $entity();
        }

        $this->entity = $entity;

        if ($data) {
            $this->setData($data);
        }

        return $this;
    }

    public function setData($data, $entity = null)
    {
        if ($entity) {
            $this->setEntity($entity);
        }

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        foreach ($data as $key => $value) {
            $setMethod = 'set'.ucfirst($this->camelcase($key));
            $this->entity->$setMethod($value);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $methods = get_class_methods($this->entity);
        $data = [];

        foreach ($methods as $method) {
            if (0 === stripos($method, 'get')) {
                $key = $this->snakecase(substr($method, 3));
                $value = $this->entity->$method();
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * @TODO add authorization checks
     *
     * @param bool $flush whether tp flush or no to the db
     * @return EntityWrapper
     */
    public function persist($flush = true)
    {
        $this->em->persist($this->entity);
        if ($flush) {
            $this->em->flush();
        }

        return $this;
    }

    protected function camelcase($str)
    {
        $result = Util\Inflector::camelize($str);

        return $result;
    }

    protected function snakecase($str)
    {
        $result = Util\Inflector::tableize($str);

        return $result;
    }
}
