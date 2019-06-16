<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoBookingOnSundayValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $day = $value->format('w');

        if ($day == "0"){
            $this->context->buildViolation($constraint->message)
                ->addViolation();

        }
    }
}