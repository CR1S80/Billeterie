<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\VisitTicketsType;
use App\Form\VisitType;
use App\Manager\VisitManager;
use App\Repository\TicketRepository;
use App\Service\PublicHolidaysService;
use Doctrine\Common\Persistence\ObjectManager;

use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Request;


class TicketController extends AbstractController
{
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
    public function order(Request $request, VisitManager $visitManager, PublicHolidaysService $publicHolidaysService)
    {
        $visit = $visitManager->initVisit();
        $publicHolidays = $publicHolidaysService->getPublicHolidaysOnTheseTwoYears();
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $visitManager->generateTickets($visit);
            return $this->redirect($this->generateUrl('app_visit_identify'));
        }
        return $this->render('Visit/order.html.twig', array('form' => $form->createView(), 'publicHolidays' => $publicHolidays));
    }

    public function customerData(Request $request): Response {

        $form = $this->createForm(VisitTicketsType::class);

        $form->handleRequest($request);

        return $this->render('ticket/customer.html.twig', [
            'form' => $form->createView()
        ]);
    }

       /* $ticket = new Ticket();

        $form = $this->createFormBuilder($ticket)
            ->add('visitAt', DateType::class/* [
                'label' => 'Votre date de visite',
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de billet',
                'choices' => [
                    'Journée' => true,
                    'Demi-journée' => false]])
            ->add('numberOfTicket', ChoiceType::class, ['label' => 'Nombre de place','choices' => array_combine(range(1, 10), range(1, 10))])


            ->getForm();

        $form->handleRequest($request);

        //dump($ticket);



        if ($form->isSubmitted() /*&& $form->isValid()) {

            return $this->render('ticket/customer.html.twig', [
                'ticket' => $ticket,
                'form' => $form,


            ]);
        }

        return $this->render('ticket/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/identification", name="identification")
     * @param Request $request
     * @param TicketRepository $ticket
     * @return Response
     */
    /*public function identificationTickets(Request $request, TicketRepository $ticket) {


        $formm = $this->createFormBuilder($ticket)
            ->add('lastname', TextType::class,[
                'label' => 'Nom'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',

                // this is actually the default format for single_text
                'format' => 'dd-MM-yyyy',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day' => 'Jour',
                ]
            ])
            ->add('country', CountryType::class, ['label' => 'Nationalité','preferred_choices' => ['FR']])
            ->add('reducedPrice', CheckboxType::class,[
                'label' => 'Prix réduit'
            ])

            ->getForm();

        $formm->handleRequest($request);

        //dump($ticket);

        return $this->render('ticket/customer.html.twig', [
            'ticket' => $ticket,
            'formm' => $formm->createView()
        ]);
    }*/



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
