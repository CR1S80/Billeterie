<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ReservationLimitAfterHour
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class ReservationLimitAfterHour extends Constraint
{

    public $hour;

    public function __construct($options = null)
    {
        parent::__construct($options);
    }
    public function getRequiredOptions()
    {
        return array('hour');
    }
    public function getMessage()
    {
        return 'constraint.limited_reservation_after_hour' ;
    }
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}