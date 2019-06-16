<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;


/**
 * Class NoBookingOnSunday
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class NoBookingOnSunday extends Constraint
{

    public $message = 'constraint.no_reservation_on_sunday';


}