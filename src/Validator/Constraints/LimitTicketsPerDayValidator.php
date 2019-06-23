<?php


namespace App\Validator\Constraints;


use App\Entity\Visit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class LimitTicketsPerDayValidator
 * @package App\Validator\Constraints
 */
class LimitTicketsPerDayValidator extends ConstraintValidator
{
    private $em;
    /**
     * LimitTicketsPerDay constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $object
     * @param Constraint $constraint
     */
    public function validate($object, Constraint $constraint)
    {
        if(!$constraint instanceof LimitTicketsPerDay){
            return ;
        }
        if(!$object instanceof Visit){
            return ;
        }
        /**
         * @var $visitDate
         */
        $visitDate = $object->getVisitDate();
        $totalForThisDay = $this->em->getRepository(Visit::class)->getNumberOfTicketForADay($visitDate);
        if( $totalForThisDay["SumTickets"] + $object->getNumberOfTicket() > Visit::NB_TICKET_MAX_DAY) {

            $this->context->buildViolation($constraint->message)
                ->atPath('numberOfTicket')
                ->addViolation();
        }
    }

}