<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class LimitOneYearBooking
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class LimitOneYearBooking extends Constraint
{
    public $message = "constraint.visit.max.visitdate";
}