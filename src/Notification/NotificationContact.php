<?php
namespace App\Notification;

use App\Entity\Contact;
use http\Env;
use Twig\Environment;

class NotificationContact{


    /**
     * NotificationContact constructor.
     */
    public function __construct(\Swift_Mailer $mailer,Environment $renderer)
    {
        $this->mailer=$mailer;
        $this->renderer=$renderer;
    }

    //cette fonction permet a un utilisateur d'envoyer un email a l'administrateur (dans un cas avances , les emails seront envoyer a l'annonceur)
    public function notify(Contact $contact){

        $x=$contact->getImmobilier()->getEmail();

        $message = (new \Swift_Message('Fashe:'.$contact->getImmobilier()->getTitle()))
            ->setFrom('sedkolod71@gmail.com')//$contact->getEmail()
            ->setTo($contact->getImmobilier()->getEmail())//
            ->setReplyTo($contact->getEmail())//$contact->getEmail()
            ->setBody(
                '<html>' .
                ' <body>' .
                'bonjour je suis  '.
                $contact->getFirstname().
                ' '.
                $contact->getLastname().
                'je peut vous contacter sur votre annonce  '.
                $contact->getImmobilier()->getTitle().
                'vous pouvez repondre sur ce mail'.
                '  '.
                $contact->getEmail().
                ' </body>' .
               '</html>','text/html');


       $this->mailer->send($message);
    }
}
?>