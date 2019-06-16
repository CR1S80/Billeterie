<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class HourLimitToday
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class HourLimitToday extends Constraint
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
        return 'constraint.to_late_for_today';
    }


}