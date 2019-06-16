<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class NoBoonkingOnTuesday
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class NoBookingOnTuesday extends Constraint
{
    public $message = 'constraint.no_reservation_on_tuesday';
}