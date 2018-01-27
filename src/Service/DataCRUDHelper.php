<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 19/01/18
 * Time: 15.26
 */

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class DataCRUDHelper
{
    /**
     * @var ObjectManager
     */
    protected $em;
    /**
     * @var TraceableValidator
     */
    protected $validator;

    protected $errors = [];

    protected $wrapper;

    public function __construct(ObjectManager $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->wrapper = new EntityWrapper();
    }

    /**
     * @param string|Entity $entity
     * @param array $data
     * @return $this
     */
    public function setEntity($entity, $data = null)
    {
        $this->wrapper->setEntity($entity, $data);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntity(){
        return $this->wrapper->getEntity();
    }

    /**
     * @TODO add authorization checks
     *
     * @param bool $flush whether tp flush or no to the db
     * @return DataCRUDHelper
     */
    public function persist($flush = true)
    {
        $this->em->persist($this->wrapper->getEntity());
        if ($flush) {
            $this->em->flush();
        }

        return $this;
    }

    protected function formatValidateErrors($errors) {
        $_errors = [];
        if (count($errors) > 0) {
            $_errors = [];
            foreach ($errors as $violation) {
                $error = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
                array_push($_errors, $error);
            }
            $this->errors['violations'] = $_errors;
        }
        return $_errors;
    }

    public function validate()
    {
        $errors = $this->validator->validate($this->wrapper->getEntity());
        return $this->formatValidateErrors($errors);
    }

    protected function formatExceptionErrors($excp)
    {
        $this->errors['exception'] = $excp->getMessage();
    }


    public function create($entity, $data)
    {
        $response = [];
        $this->setEntity($entity, $data);
        if (!$this->validate()) {
            try {
                $this->persist();
                $response['statusCode'] = 201;
                $response['data'] =$this->wrapper->getData();
                $response['id'] = $this->wrapper->getEntity()->getId();
            } catch (\Exception $e) {
                $this->formatExceptionErrors($e);
            }
        }
        if ($this->errors) {
            $response['statusCode'] = 400;
            $response['data'] = ['error' => $this->errors];
        }

        return $response;
    }

    public function update($entityName, $data)
    {
        $response = [];
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        if (!$data || !array_key_exists('id', $data)) {
            $response['statusCode'] = 404;
            $response['data'] = ['error' => "Invalid data"];
        }
        $entity = $this->em->find($entityName, $data['id']);
        if ($entity) {
            $this->setEntity($entity, $data);
            if (!$this->validate()) {
                try {
                    $this->persist();
                    $response['statusCode'] = 200;
                    $response['data'] =$this->wrapper->getData();
                } catch (\Exception $e) {
                    $this->formatExceptionErrors($e);
                }
            }
        } else {
            $response['statusCode'] = 404;
            $response['data'] = ['error' => "No data [ID=${$data['id']}]"];
        }
        return $response;
    }

    public function delete($entityName, $id) {
        $response = [];
        $entity = $this->em->find($entityName, $id);

        if ($entity) {
            try {
                $this->em->remove($entity);
                $this->em->flush();
                $response['statusCode'] = 200;
                $response['data'] = "Successfully deleted [$id] entity";
            } catch (\Exception $e) {
                $this->formatExceptionErrors($e);
            }
        } else {
            $response['statusCode'] = 404;
            $response['data'] = ['error' => "No data [ID=$id]"];
        }
        return $response;
    }

}