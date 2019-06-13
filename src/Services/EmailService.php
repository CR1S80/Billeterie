<?php


namespace App\Services;


use App\Entity\Visit;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @property Swift_Mailer mailer
 * @property Environment renderer
 */
class EmailService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;

    }


    /**
     * @param Visit $visit
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendMailConfirmation(Visit $visit)
    {

        $email = $visit->getCustomer()->get(0)->getEmail();


        $message = (new Swift_Message('Confirmation de votre réservation'))
            ->setFrom('noreply@louvre.fr')
            ->setTo($email)
            ->setBody($this->renderer->render('email/mailConfirmation.html.twig', [
                'customer' => $visit->getCustomer()->get(0),
                'visit' => $visit,
                'message' => $visit->getBookingID()
            ]), 'text/html');


        return $this->mailer->send($message);


    }

    public function contact($data) {
        $message = (new Swift_Message($data['subject']))
            ->setFrom($data['email']) // je récupère l'adresse donnée par l'internaute dans le formulaire.
            // Dans le controller, j'ai appelé les datas par  $emailService->sendMailContact($form->getData());
            ->setTo('louvre.billeterie@cpdmdev-mg.fr') // je récupère l'adresse que j'ai enregistré dans parameters.yml grâce à cet argument
            ->setBody($this->renderer->render('email/mailContact.html.twig',
                array('data' => $data)))
            ->setContentType('text/html');
        $this->mailer->send($message);
    }
}