<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints\TypeValidator;

class NullableTypeValidator extends TypeValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!is_null($value)) {
            parent::validate($value, $constraint);
        }
    }
}