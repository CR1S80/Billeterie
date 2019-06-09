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
                'visit' => $visit->getCustomer()->get(0)
            ]), 'text/html');


        return $this->mailer->send($message);


    }
}