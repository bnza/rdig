<?php

namespace App\Service;

use App\Entity\CrudEntityInterface;
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
        'site' => 'App\Entity\Site',
        'area' => 'App\Entity\Area',
        'context' => 'App\Entity\Context',
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

    public function getEntityClass(string $entityClassKey)
    {
        if (array_key_exists($entityClassKey, $this->entityClasses)) {
            return $this->entityClasses[$entityClassKey];
        }
        throw new NotFoundEntityCrudException($entityClassKey);
    }

    public function getRepository(string $entityClassKey)
    {
        return $this->em->getRepository($this->getEntityClass($entityClassKey));
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

        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                // value is an entity instance?
                if (is_array($value) && array_key_exists('id', $value)) {
                    // TODO nest array_key_exists check
                    // retrieve it from repository
                   $value = $this->getRepository($key)->find($value['id']);
                }
                $setMethod = 'set'.ucfirst($this->camelcase($key));
                if (method_exists($this->entity, $setMethod)) {
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
