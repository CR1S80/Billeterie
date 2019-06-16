<?php


namespace App\Validator\Constraints;



use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PublicHolidaysValidator extends ConstraintValidator
{



    public function validate($value, Constraint $constraint) {

        // French public holidays

        $year = $value->format("Y");
        $easterDate=easter_date($year);
        $easterDateTime= new \DateTime("@$easterDate");
        $easterDateTime=$easterDateTime->format("Y/m/d");
        $paques=date("Y/m/d",strtotime("+1 day", $easterDate));// Paques
        $ascenssion=date("Y/m/d",strtotime("+39 day", $easterDate)); // Ascenssion
        $pentecotes=date("Y/m/d",strtotime("+50 day", $easterDate));// Pentecotes
        $NewyearsDay=$year."/01/01";// 1er janvier
        $workHoliday=$year."/10/02";// Fete du travail
        $victoireAllies=$year."/05/08";// Victoire des allies
        $fetenat=$year."/07/14";// Fete nationale
        $assomption=$year."/08/15";// Assomption
        $toussaint=$year."/11/01";// Toussaint
        $armistice=$year."/11/11";// Armistice
        $noel=$year."/12/25";// Noel

       $day = false;

         switch ($value->format('Y/m/d')) {
             case $workHoliday:
             case $easterDateTime:
             case $paques:
             case $ascenssion:
             case $pentecotes:
             case $NewyearsDay:
             case $victoireAllies:
             case $fetenat:
             case $assomption:
             case $toussaint:
             case $armistice:
             case $noel:
                 $day = true;
                 break;
             default;
         }
//
        if ($day == true ) {

            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

}