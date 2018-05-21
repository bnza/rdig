<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Type;

/**
 * @Annotation
 */
class NullableType extends Type
{
    public $message = 'This value should be null or of type {{ type }}.';
}