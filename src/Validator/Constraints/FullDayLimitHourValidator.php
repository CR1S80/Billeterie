<?php


namespace App\Validator\Constraints;


use App\Entity\Visit;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FullDayLimitHourValidator extends ConstraintValidator
{

    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @throws \Exception
     */
    public function validate($object, Constraint $constraint)
    {
        $hour = date("H");
        if(!$object instanceof Visit)
        {
            return;
        }
        if($object->getType() == Visit::TYPE_FULL_DAY &&
            $hour >= $constraint->hour &&
            $object->getVisitDate()->format('dmY') === date('dmY')
        )
        {
            $this->context->buildViolation($constraint->getMessage())
                ->setParameter('%hour%',$constraint->hour)
                ->atPath('type')
                ->addViolation();
        }
    }

}