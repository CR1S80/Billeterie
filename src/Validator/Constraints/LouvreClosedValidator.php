<?php


namespace App\Validator\Constraints;



use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LouvreClosedValidator extends ConstraintValidator
{

    public function getholidays($year = null) {

        if ($year === null)
        {
            $year = intval(strftime('%Y'));
        }

        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);

        $holidays = [
            // Jours feries fixes
            mktime(0, 0, 0, 1, 1, $year),// 1er janvier
            mktime(0, 0, 0, 5, 1, $year),// Fete du travail
            mktime(0, 0, 0, 5, 8, $year),// Victoire des allies
            mktime(0, 0, 0, 7, 14, $year),// Fete nationale
            mktime(0, 0, 0, 8, 15, $year),// Assomption
            mktime(0, 0, 0, 11, 1, $year),// Toussaint
            mktime(0, 0, 0, 11, 11, $year),// Armistice
            mktime(0, 0, 0, 12, 25, $year),// Noel

            // Jour feries qui dependent de paques
            mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear),// Lundi de paques
            mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),// Ascension
            mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), // Pentecote
        ];

        return $holidays;
    }

    public function validate($value, Constraint $constraint) {



        if ($value->format('d/m/Y') === "17/06/2019") {
            dump($this->getholidays(2019));
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

}