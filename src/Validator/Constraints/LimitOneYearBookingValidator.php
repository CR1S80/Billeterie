<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LimitOneYearBookingValidator extends ConstraintValidator
{


    public function validate($value, Constraint $constraint)
    {
        $now = new \DateTime();
        $diff = $now->diff($value);

        if ($diff->format("%a" > 365)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}