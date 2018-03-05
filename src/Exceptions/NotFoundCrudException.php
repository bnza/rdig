<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 03/02/18
 * Time: 16.59.
 */

namespace App\Exceptions;

class NotFoundCrudException extends CrudException
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $pieces = explode(",", $message);
        $id = $pieces[0];
        $element = isset($pieces[1]) ? $pieces[1] : 'element';
        $message = "No $element found with ID = $message";
        parent::__construct($message, $code, $previous);
    }
}
