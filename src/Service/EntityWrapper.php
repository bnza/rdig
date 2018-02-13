<?php

namespace App\Service;

use Doctrine\Common\Util;
use Doctrine\ORM\Mapping\Entity;

class EntityWrapper
{

    protected $entity;

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

    /**
     * @return mixed
     */
    public function getEntity(){
        return $this->entity;
    }

    public function setData($data, $entity = null)
    {
        if ($entity) {
            $this->setEntity($entity);
        }

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        $entity = $this->entity;
        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                $setMethod = 'set'.ucfirst($this->camelcase($key));
                if (method_exists($entity, $setMethod)) {
                    $this->entity->$setMethod($value);
                }
            }
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
