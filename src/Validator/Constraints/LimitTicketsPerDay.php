<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class LimitTicketsPerDay
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class LimitTicketsPerDay extends Constraint
{

    public $message = "constraint.one_thousand_tickets";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}