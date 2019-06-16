<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class HourLimitToday extends Constraint
{
    public $message =  'constraint.limited_reservation_after_hour' ;

}