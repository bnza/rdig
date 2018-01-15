<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 15/01/18
 * Time: 18.01.
 */

namespace App\Service;

use Doctrine\Common\Util;

class EntityWrapper
{
    public $entity;

    public function __construct($entity, $data = false)
    {
        if (is_string($entity) && class_exists($entity)) {
            $entity = new $entity();
        }

        $this->entity = $entity;

        if ($data) {
            $this->setData($data);
        }
    }

    public function setData($data)
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        foreach ($data as $key => $value) {
            $setMethod = 'set'.ucfirst($this->camelcase($key));
            $this->entity->$setMethod($value);
        }

        return $this;
    }

    public function getData($asJson = false)
    {
        $methods = get_class_methods($this->entity);
        $data = [];

        foreach ($methods as $method) {
            if (stripos($method, 'get') === 0) {
                $key = $this->snakecase(substr($method, 3));
                $value = $this->entity->$method();
                $data[$key] = $value;
            }
        }

        if ($asJson) {
            $data = json_encode($data);
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
