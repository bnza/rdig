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
        $this->wrapper = new EntityWrapper();
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
     * @return array
     * @throws DataValidationCrudException
     */
    public function create($entity, $data)
    {
        $response = [];
        $this->setEntity($entity, $data, true);
        $this->persist();
        $response['statusCode'] = 201;
        $response['data'] = $this->wrapper->getData();
        $response['id'] = $this->wrapper->getEntity()->getId();

        return $response;
    }

    /**
     * @param string       $entityName
     * @param string|array $data
     *
     * @return array
     *
     * @throws InvalidRequestDataCrudException
     * @throws NotFoundCrudException
     * @throws DataValidationCrudException
     */
    public function update(string $entityName, $data)
    {
        $response = [];
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        if (!$data || !array_key_exists('id', $data)) {
            throw new InvalidRequestDataCrudException('No id supplied');
        }
        $entity = $this->em->find($entityName, $data['id']);
        if ($entity) {
            $this->setEntity($entity, $data, true);
            $this->persist();
            $response['statusCode'] = 200;
            $response['data'] = $this->wrapper->getData();
        } else {
            throw new NotFoundCrudException($data['id']);
        }

        return $response;
    }

    /**
     * @param string $entityName
     * @param int    $id
     *
     * @return array
     *
     * @throws NotFoundCrudException
     */
    public function delete(string $entityName, int $id)
    {
        $response = [];
        $entity = $this->em->find($entityName, $id);

        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
            $response['statusCode'] = 200;
            $response['data'] = "Successfully deleted [$id] entity";
        } else {
            throw new NotFoundCrudException($id);
        }

        return $response;
    }
}
