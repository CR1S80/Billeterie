<?php


namespace App\Validator\Constraints;

use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\Validator\Constraint;

/**
 * Class PublicHolidays
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class PublicHolidays extends Constraint
{
    public $message = 'constraint.no_reservation_louvre_closed';

}