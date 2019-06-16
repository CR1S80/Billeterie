<?php


namespace App\Validator\Constraints;

use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\Validator\Constraint;

/**
 * Class LouvreClosed
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class LouvreClosed extends Constraint
{
    public $message = 'constraint.no_reservation_louvre_closed';

}