<?php

namespace App\Controller;


use App\Entity\Customer;
use App\Entity\Ticket;
use App\Entity\Visit;
use App\Form\CustomerType;
use App\Form\VisitCustomerType;
use App\Form\VisitTicketsType;
use App\Form\VisitType;
use phpDocumentor\Reflection\Types\This;
use App\Manager\VisitManager;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;


class TicketController extends AbstractController
{
    private $session = [];

    /**
     * page d'acceuil
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('ticket/home.html.twig', [
            "current_menu" => "home"
        ]);
    }

    /**
     * premiere étape de la commmande
     * @Route("/order", name="order")
     * @param Request $request
     * @param VisitManager $visitManager
     * @return Response
     */
    public function order(Request $request, VisitManager $visitManager): Response
    {
        $visit = $visitManager->initVisit();

        dump($visit);
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $visitManager->generateTickets($visit);
            $visitManager->generateCustomer($visit);


            return $this->redirect($this->generateUrl('customer'));

        }
        return $this->render('ticket/order.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route ("/customer", name="customer")
     * @param Request $request
     * @param VisitManager $visitManager
     * @return Response
     * @throws \Exception
     */
    public function customerData(Request $request, VisitManager $visitManager): Response
    {

        $visit = $visitManager->getCurrentVisit();

        dump($visit);
        $form = $this->createForm(VisitTicketsType::class, $visit);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $visitManager->calculPrice($visit);
            return $this->redirect($this->generateUrl('adress'));
        }
        return $this->render('ticket/customer.html.twig', array('form' => $form->createView(), 'visit' => $visit,));
    }

    /**
     * @Route ("/adress", name="adress")
     * @param VisitManager $visitManager
     * @param Request $request
     * @return Response
     */
    public function adressCustomer(Request $request, VisitManager $visitManager): Response
    {

        $visit = $visitManager->getCurrentVisit();


        $form = $this->createForm(VisitCustomerType::class, $visit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Création du booking code
            $visitManager->genrateBookindId($visit);

            return $this->redirect($this->generateUrl('pay'));
        }


        return $this->render('ticket/adress.html.twig', [
            'form' => $form->createView(),
            'visit' => $visit,

        ]);
    }

    /**
     * @Route ("/pay", name="pay")
     * @param Request $request
     * @param VisitManager $visitManager
     * @return Response
     * @throws \Exception
     */
    public function payStep(Request $request, VisitManager $visitManager)
    {




        $visit = $visitManager->getCurrentVisit();

        dump($visit);


        if ($request->getMethod() === "POST") {
            //Création de la charge - Stripe
            $token = $request->request->get('stripeToken');
            // chargement de la clé secrète de Stripe
            $secretkey = 'sk_test_4ytoBcxJI4ZSiCh2x75Y1XWc00njXRh8FE';
            // paiement
            Stripe::setApiKey($secretkey);

            Charge::create(array(
                "amount" => $visitManager->calculPrice($visit) * 100,
                "currency" => "eur",
                "source" => $token,
                "description" => "Réservation sur la billetterie du Musée du Louvre"));

            // enregistrement dans la base

            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();

            return $this->redirect($this->generateUrl('confirmation'));
        }

        return $this->render('ticket/pay.html.twig', [

            'visit' => $visit,

        ]);


    }

    /**
     * @Route ("confirmation", name="confirmation")
     * @param VisitManager $visitManager
     * @return Response
     */
    public function confirmation(VisitManager $visitManager)
    {

        $visit = $visitManager->getCurrentVisit(Visit::IS_VALID_WITH_BOOKINGCODE);

        return $this->render('ticket/confirmation.html.twig');
    }


    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('ticket/contact.html.twig', [
            "current_menu" => "contact"
        ]);
    }
}
