<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 03/02/18
 * Time: 16.59.
 */

namespace App\Exceptions;

class NotFoundEntityCrudException extends CrudException
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $message = "No entity found with name = $message";
        parent::__construct($message, $code, $previous);
    }
}
