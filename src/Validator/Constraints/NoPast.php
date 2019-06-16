<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class NoPast extends Constraint
{
    public $message = "constraint.visit.min.visitdate";
}