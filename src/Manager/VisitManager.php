<?php


namespace App\Manager;


use App\Entity\Customer;
use App\Entity\Ticket;
use App\Entity\Visit;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VisitManager
{
    const SESSION_ID_CURRENT_VISIT = "visit";

    private $session;

    /**
     * VisitManager constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Initialisation de la visite et de la session
     * @return Visit
     * @throws \Exception
     */
    public function initVisit()
    {
        $visit = new Visit();
        $visit->setInvoiceDate(new \DateTime());
        $this->session->set(self::SESSION_ID_CURRENT_VISIT,$visit);

        return $visit;

    }

    public function getCurrentVisit($validateBy = null)
    {
        $visit = $this->session->get(self::SESSION_ID_CURRENT_VISIT);

        return $visit;

    }

    /**
     * @param Visit $visit
     * @return Visit
     * @throws \Exception
     */
    public function generateTickets(Visit $visit)
    {
        for($i= 1; $i<=$visit->getNumberOfTicket(); $i++)
        {
            $visit->addTicket(new Ticket());
        }
        return $visit;
    }

    public function generateCustomer(Visit $visit)
    {

            $visit->addCustomer(new Customer());

        return $visit;
    }

    /**
     * @param Visit $visit
     * @return Ticket|int
     * @throws \Exception
     */
    public function calculPrice(Visit $visit)
    {

        $totalPrice = 0;
        foreach ($visit->getTickets() as $ticket) {
            $priceTicket = $this->calculTicketPrice($ticket);


            $totalPrice += $priceTicket->getPrice();


        }
        $visit->setTotalPrice($totalPrice);
        return $totalPrice;
    }

    /**
     * @param Ticket $ticket
     * @return Ticket
     * @throws \Exception
     */
    public function calculTicketPrice(Ticket $ticket)
    {

        $birthday = $ticket->getBirthday();
        $today = new \DateTime();
        $age = \date_diff($birthday, $today)->y;



        if($age < Ticket::AGE_CHILD){ // Bébé
            $price = Ticket::PRICE_FREE;
        }elseif($age < Ticket::AGE_ADULT){ //Enfant
            $price = Ticket::PRICE_CHILD;
        }elseif ($age < Ticket::AGE_SENIOR){ // Adulte/Normal
            $price = Ticket::PRICE_ADULT;
        }else{ // Senior
            $price = Ticket::PRICE_SENIOR;
        }
        // Verifier reduction
        if($ticket->getReducedPrice() === true && $price > Ticket::PRICE_DISCOUNT && $price != Ticket::PRICE_SENIOR ){
            $price = Ticket::PRICE_DISCOUNT;
        }
        //Appliquer coeff journée/demi journée
        if($ticket->getVisit()->getType() === Visit::TYPE_HALF_DAY){
            $price = $price * Ticket::PRICE_HALF_DAY_COEFF;
        }



        $ticket->setPrice($price);

        return $ticket;
    }

    public function genrateBookindId(Visit $visit) {


            $mail = $visit->getCustomer()->get(0)->getEmail();
            $firstname = $visit->getCustomer()->get(0)->getFirstname();
            $key = $firstname . $mail . time() . mt_rand();
            $keyLength = rand (8, 18);
            $bookingId = substr(str_shuffle($key),0, $keyLength);
            $visit->setBookingID($bookingId);

            return $visit;

    }




}