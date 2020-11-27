<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AlphaNumericValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\AlphaNumeric */
        if(!$constraint instanceof AlphaNumeric){
            throw new UnexpectedTypeException($constraint, AlphaNumeric::class);
        }
        if (null === $value || '' === $value) {
            return;
        }

        if(!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches)) {
            
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
        }

    }
}
