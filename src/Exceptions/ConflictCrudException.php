<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 03/02/18
 * Time: 16.59.
 */

namespace App\Exceptions;

class ConflictCrudException extends CrudException
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $message = "An element with ID = $message already exists";
        parent::__construct($message, $code, $previous);
    }
}
