<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class FullDayLimitHour
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class FullDayLimitHour extends Constraint
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

    //public $message = 'constraint.limited_reservation_after_hour';


}