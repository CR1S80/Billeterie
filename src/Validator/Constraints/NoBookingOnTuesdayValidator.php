<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoBookingOnTuesdayValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $day = $value->format('w');

        if ($day == "2"){
            $this->context->buildViolation($constraint->message)
                ->addViolation();

        }
    }
}