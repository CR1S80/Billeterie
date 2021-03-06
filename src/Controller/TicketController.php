<?php

namespace App\Controller;


use App\Entity\Visit;
use App\Form\ContactType;
use App\Form\VisitCustomerType;
use App\Form\VisitTicketsType;
use App\Form\VisitType;
use App\Manager\VisitManager;
use App\Services\EmailService;
use Endroid\QrCode\Factory\QrCodeFactoryInterface;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as RequestAlias;
use Symfony\Component\Validator\Constraints\DateTime;


class TicketController extends AbstractController
{


    private $session = [];

    /**
     * page d'acceuil
     * @Route({
     *     "fr": "/",
     *     "en": "/en",
     *}, name="home")
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
     * @param RequestAlias $request
     * @param VisitManager $visitManager
     * @return Response
     * @throws \Exception
     */
    public function order(RequestAlias $request, VisitManager $visitManager): Response
    {
        $visit = $visitManager->initVisit();


        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $visit = $visitManager->getCurrentVisit();

            $visitManager->generateTickets($visit);
            $visitManager->generateCustomer($visit);



            return $this->redirect($this->generateUrl('customer'));

        }
        return $this->render('ticket/order.html.twig', [
            'form' => $form->createView(),
            'message' => false,
        ]);
    }

    /**
     * @Route ("/customer", name="customer")
     * @param RequestAlias $request
     * @param VisitManager $visitManager
     * @return Response
     * @throws \Exception
     */
    public function customerData(RequestAlias $request, VisitManager $visitManager): Response
    {


        $visit = $visitManager->getCurrentVisit();

        $form = $this->createForm(VisitTicketsType::class, $visit);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $visitManager->calculPrice($visit);
            return $this->redirect($this->generateUrl('address'));
        }
        return $this->render('ticket/customer.html.twig', [
            'form' => $form->createView(),
            'visit' => $visit
        ]);
    }

    /**
     * @Route ("/address", name="address")
     * @param VisitManager $visitManager
     * @param RequestAlias $request
     * @return Response
     */
    public function addressCustomer(RequestAlias $request, VisitManager $visitManager): Response
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
            'customer' => $visit->getCustomer()->get(0),

        ]);
    }

    /**
     * @Route ("/pay", name="pay")
     * @param RequestAlias $request
     * @param VisitManager $visitManager
     * @return Response
     * @throws \Exception
     */
    public function payStep(RequestAlias $request, VisitManager $visitManager, EmailService $emailService)
    {


        $visit = $visitManager->getCurrentVisit();

        if ($visit->getTotalPrice() > 0) {


            if ($request->getMethod() === "POST") {
                //Création de la charge - Stripe
                $token = $request->request->get('stripeToken');
                // chargement de la clé secrète de Stripe
                $secretkey = 'sk_test_4ytoBcxJI4ZSiCh2x75Y1XWc00njXRh8FE';
                // paiement
                Stripe::setApiKey($secretkey);

                try {
                    Charge::create([

                        "amount" => $visitManager->calculPrice($visit) * 100,
                        "currency" => "eur",
                        "source" => $token,
                        "description" => "Réservation sur la billetterie du Musée du Louvre",
                        'metadata' => [
                        "Lastname" => $visit->getCustomer()->get(0)->getLastname(),
                        "Firstname" => $visit->getCustomer()->get(0)->getFirstname(),
                        "NumberTickets" => $visit->getnumberOfTicket(),

                        ]

                    ]);


                    // enregistrement dans la base

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($visit);
                    $em->flush();
                    $this->addFlash('notice', 'flash.payment.success');
                    $emailService->sendMailConfirmation($visit);

                    return $this->redirect($this->generateUrl('confirmation'));

                } catch (\Exception $e) {
                   // echo 'Exception reçue : ',  $e->getMessage(), "\n";
                   $this->addFlash('danger', 'flash.payment.error');
                }
            }
        } else {



            if ($request->getMethod() === "POST") {
                $em = $this->getDoctrine()->getManager();
                $em->persist($visit);
                $em->flush();
                $this->addFlash('notice', 'flash.payment.success');
                $emailService->sendMailConfirmation($visit);

                return $this->redirect($this->generateUrl('confirmation'));
            }
        }

        return $this->render('ticket/pay.html.twig', [

            'visit' => $visit,
            'customer' => $visit->getCustomer()->get(0),
            'Amount' => $visit->getTotalPrice() > 0

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
        $qr = $visit->getBookingID();


        return $this->render('ticket/confirmation.html.twig', [
            'message' => $qr,
            'customer' => $visit->getCustomer()->get(0),
            'visit' => $visit,

        ]);
    }


    /**
     * page contact
     * @Route("/contact", name="contact")
     * @param RequestAlias $request
     * @param EmailService $emailService
     * @return RedirectResponse|Response
     */
    public function contactAction(RequestAlias $request, EmailService $emailService)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailService->contact($form->getData());
            $this->addFlash('notice', 'message.contact.send');
            return $this->redirect($this->generateUrl('contact'));
        }
        return $this->render('Ticket/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
