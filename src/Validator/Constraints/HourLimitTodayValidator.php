<?php


namespace App\Validator\Constraints;


use App\Entity\Visit;
use function Date;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HourLimitTodayValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$value instanceof \DateTime) return;
        $hour = Date("H");
        if($value->format("dd/mm/yyyy") === date("dd/mm/yyyy") && $hour >= $constraint->hour)
        {
            $this->context->buildViolation($constraint->getMessage())
                ->setParameter('%hour%',$constraint->hour)
                ->addViolation();
        }
    }
}