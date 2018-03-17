<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Exceptions\NotFoundCrudException;
use App\Exceptions\InvalidRequestDataCrudException;
use App\Exceptions\DataValidationCrudException;

class DataCrudHelper
{
    /**
     * @var ObjectManager
     */
    protected $em;
    /**
     * @var ValidatorInterface
     */
    protected $validator;
    /**
     * @var array
     */
    protected $errors = [];
    /**
     * @var EntityWrapper
     */
    protected $wrapper;

    /**
     * DataCrudHelper constructor.
     *
     * @param ObjectManager      $em
     * @param ValidatorInterface $validator
     */
    public function __construct(ObjectManager $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->wrapper = new EntityWrapper($em);
    }

    public function getRepository()
    {
        if ($entity = $this->getEntity()) {
            return $this->em->getRepository(get_class($entity));
        }
        throw new \LogicException('You must set entity before!');
    }

    /**
     * @param string|Entity $entity
     * @param array         $data
     * @param bool          $validate
     *
     * @return $this
     *
     * @throws DataValidationCrudException
     */
    public function setEntity($entity, $data = null, $validate = false)
    {
        $this->wrapper->setEntity($entity, $data);

        if ($validate) {
            $this->validate();
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->wrapper->getEntity();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->wrapper->getData();
    }

    /**
     * @TODO add authorization checks
     *
     * @param bool $flush whether tp flush or no to the db
     *
     * @return DataCrudHelper
     */
    public function persist($flush = true)
    {
        $this->em->persist($this->wrapper->getEntity());
        if ($flush) {
            $this->em->flush();
        }

        return $this;
    }

    /**
     * @throws DataValidationCrudException
     */
    public function validate()
    {
        $errors = $this->validator->validate($this->wrapper->getEntity());
        if (count($errors)) {
            $exception = new DataValidationCrudException();
            $exception->setErrors($errors);
            throw $exception;
        }
    }

    /**
     * @param $entity
     * @param $data
     *
     * @return array
     *
     * @throws DataValidationCrudException
     */
    public function create($entity, $data)
    {
        $this->setEntity($entity, $data, true);
        $this->persist();

        return $this->getCreateResponseArray();
    }

    public function getCreateResponseArray()
    {
        $response = [];
        $response['statusCode'] = 201;
        $response['data'] = $this->wrapper->getData();
        $response['id'] = $this->wrapper->getEntity()->getId();

        return $response;
    }

    /**
     * @param $entityName
     * @param int|string $data
     *
     * @return object
     *
     * @throws InvalidRequestDataCrudException
     * @throws NotFoundCrudException
     * @throws DataValidationCrudException
     */
    public function read($entityName, $data)
    {
        $id = false;
        if (is_int($data)) {
            $id = $data;
        } elseif (is_string($data)) {
            $data = json_decode($data, true);
            if ($data && array_key_exists('id', $data)) {
                $id = $data['id'];
            }
        }

        if (false === $id) {
            throw new InvalidRequestDataCrudException('No id supplied');
        }

        $entity = $this->em->find($entityName, $id);
        $this->setEntity($entity);
        if (!$entity) {
            throw new NotFoundCrudException($id);
        }

        return $entity;
    }

    /**
     * @param              $entity
     * @param string|array $data
     *
     * @return array
     *
     * @throws DataValidationCrudException
     */
    public function update($entity, $data)
    {
        $response = [];

        $this->setEntity($entity, $data, true);
        $this->persist();
        $response['statusCode'] = 200;
        $response['data'] = $this->wrapper->getData();

        return $response;
    }

    /**
     * @param string $entity
     *
     * @return array
     */
    public function delete($entity)
    {
        $id = $entity->getId();
        $this->em->remove($entity);
        $this->em->flush();
        $response['statusCode'] = 200;
        $response['data'] = "Successfully deleted [#{$id}] entity";

        return $response;
    }
}
