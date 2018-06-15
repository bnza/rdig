<?php

namespace App\Service;

use App\Entity\CrudEntityInterface;
use App\Exceptions\NotFoundCrudException;
use App\Exceptions\NotFoundEntityCrudException;
use Doctrine\Common\Util;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Persistence\ObjectManager;


class EntityWrapper
{
    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var CrudEntityInterface
     */
    protected $entity;

    protected $entityClasses = [
        'site' => 'App\Entity\Main\Site',
        'area' => 'App\Entity\Main\Area',
        'context' => 'App\Entity\Main\Campaign',
        'campaign' => 'App\Entity\Main\Campaign',
        'bucket' => 'App\Entity\Main\Bucket',
        'finding' => 'App\Entity\Main\Finding',
        'sample' => 'App\Entity\Main\Sample',
        'object' => 'App\Entity\Main\Object',
        'pottery' => 'App\Entity\Main\Pottery',
        'chronology' => 'App\Entity\Main\VocFChronology',
        'type' => 'App\Entity\Main\Voc%Type'
    ];

    /**
     * DataCrudHelper constructor.
     *
     * @param ObjectManager      $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function getEntityClass(string $entityClassKey, string $vocType = "")
    {
        if (array_key_exists($entityClassKey, $this->entityClasses)) {
            $class = $this->entityClasses[$entityClassKey];
            if ($vocType) {
                $class = str_replace("%", strtoupper($vocType), $class);
            }
            return $class;
        }
        throw new NotFoundEntityCrudException($entityClassKey);
    }

    public function getRepository(string $entityClassKey, string $vocType = "")
    {
        return $this->em->getRepository($this->getEntityClass($entityClassKey, $vocType));
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

        $vocType = array_key_exists('discr', $data) ? $data['discr'] : "";

        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                // value is an entity instance?
                if (is_array($value) && array_key_exists('id', $value)) {
                    // TODO nest array_key_exists check
                    // retrieve it from repository
                   $value = $this->getRepository($key, $vocType)->find($value['id']);
                }
                $setMethod = 'set'.ucfirst($this->camelcase($key));
                if (method_exists($this->entity, $setMethod)) {
                    $value = $value === '' ? null : $value;
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
        return $this->entity->toArray();
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
