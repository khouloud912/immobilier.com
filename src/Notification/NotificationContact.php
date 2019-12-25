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

    public function notify(Contact $contact){  //ta3mel description ala eli amer el formulaire

        $x=$contact->getImmobilier()->getEmail();

        $message = (new \Swift_Message('Fashe:'.$contact->getImmobilier()->getTitle()))
            ->setFrom('sedkolod71@gmail.com')//$contact->getEmail()
            ->setTo($contact->getImmobilier()->getEmail())//
            ->setReplyTo($contact->getEmail())//$contact->getEmail()
            ->setBody(
                $this->renderer->render('emails/contact.html.twig',[
                    'contact'=>$contact
                ]),'text/html');

       $this->mailer->send($message);
    }
}
?>