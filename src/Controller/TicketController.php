<?php

namespace App\Controller;


use App\Entity\Visit;
use App\Form\CustomerType;
use App\Form\VisitTicketsType;
use App\Form\VisitType;
use phpDocumentor\Reflection\Types\This;
use App\Manager\VisitManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class TicketController extends AbstractController
{
    private $session= [];

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
     *
     */
    public function order(Request $request, VisitManager $visitManager)
    {
        $visit = $visitManager->initVisit();

        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $visitManager->generateTickets($visit);

            return $this->redirect($this->generateUrl('customer'));

        }
        return $this->render('ticket/order.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route ("/customer", name="customer")
     * @param Request $request
     * @param VisitManager $visitManager
     * @return Response
     */
    public function customerData(Request $request, VisitManager $visitManager): Response
    {

        $visit = $visitManager->getCurrentVisit(Visit::IS_VALID_INIT);

        $form = $this->createForm(VisitTicketsType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $visitManager->calculPrice($visit);
            return $this->redirect($this->generateUrl('adress'));
        }
        return $this->render('ticket/customer.html.twig', array('form' => $form->createView(), 'visit' => $visit));
    }

    /**
     * @Route ("/adress", name="adress")
     * @param Request $request
     * @return Response
     */
    public function adressCustomer(Request $request): Response {

        $form = $this->createForm(CustomerType::class);

        $form->handleRequest($request);

        dump($_POST);

        return $this->render('ticket/adress.html.twig', [
            'form' => $form->createView(),
            //'post' => $_POST["visit"],
            //'tickeDate' => $_POST["visit"]["visitDate"],
        ]);


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
