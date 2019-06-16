<?php


namespace App\Validator\Constraints;


use App\Entity\Visit;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HourLimitTodayValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$value instanceof \DateTime) return;
        $hour = date("H");
        if($value->format('dmY') === date('dmY') && $hour >= $constraint->hour)
        {
            $this->context->buildViolation($constraint->getMessage())
                ->setParameter('%hour%',$constraint->hour)
                ->addViolation();
        }
    }
}