<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 03/02/18
 * Time: 17.48
 */

namespace App\Exceptions;

use Symfony\Component\Validator\ConstraintViolationListInterface;


class DataValidationCrudException extends CrudException
{
    /**
     * @var ConstraintViolationListInterface
     */
    protected $errors;

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param ConstraintViolationListInterface $errors
     */
    public function setErrors(ConstraintViolationListInterface $errors): void
    {
        $this->errors = $errors;
    }


}