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
        $hour = date("H");
        if(!$value instanceof Visit)
        {
            return;
        }
        if($value->getType() == Visit::TYPE_FULL_DAY &&
            $hour >= $constraint->hour &&
            $value->getVisitDate()->format('dmY') === date('dmY')
        )
        {
            $this->context->buildViolation($constraint->getMessage())
                ->setParameter('%hour%',$constraint->hour)
                ->atPath('type')
                ->addViolation();
        }
    }
}