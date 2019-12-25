<?php

namespace App\Controller;
use App\Entity\ImmobilierSearch;
use App\Form\ImmobilierSearchType;
use App\Notification\NotificationContact;
use Symfony\Component\Form\FormTypeInterface;
use App\Entity\Contact;
use App\Entity\User;

use App\Entity\Immobilier;
use App\Repository\ImmobilierRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ImmobilierType;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Security;



class ImmeubleController extends AbstractController
{
    private $repository;
    private $em;

    public function __construct(ImmobilierRepository $repository, EntityManagerInterface $em)
    {
        $this->em =$em;
        $this->repository=$repository;
    }

    /**
     * @Route("/Immeuble", name="afficher_Immeuble")
     */
    public function affiche(Request $request){
        $search= new ImmobilierSearch();
        $form=$this->createForm(ImmobilierSearchType::class,$search);
        $form->handleRequest($request);

        $immob=$this->repository->findAllVisibleQuery($search);
        $this->em->flush(); //itha bedelt haja tetsajel fil base
        return $this->render('immeuble/affiche.html.twig',[
            'immobilier'=>$immob,
            'form'=>$form->createView(),


        ]);
    }





    /**
     * @Route("/details/{slug}-{id} ", name="details_Immeuble" ,requirements={"slug": "['a-z0-9\-']*"} )
     */
    public function details(Immobilier $immobilier , string $slug, Request $request, NotificationContact $notification):\Symfony\Component\HttpFoundation\Response
    {
        $contact=new Contact();
        $contact->setImmobilier($immobilier);
        $form=$this->createForm(ContactType ::class ,$contact);


        if ($immobilier->getSlug() !== $slug){
            return $this->redirectToRoute('details_Immeuble', [
                'id'=>$immobilier->getId(),
                'slug'=>$immobilier->getSlug()
            ]);
        }
        $form->handleRequest($request);
        if ($form ->isSubmitted() && $form->isValid()){
            $notification->notify($contact);

           // $this->addFlash('succes','Succes d envoie de mail');
          /*  return $this->redirectToRoute('details_Immeuble', [
                'id'=>$immobilier->getId(),
                'slug'=>$immobilier->getSlug()
            ]);
            */


        }
        return $this->render('immeuble/details.html.twig',[
            'immobilier1'=>$immobilier,
            'form'=>$form->createView(),
        ]);
    }















    /******************************************************************************************************************************************/
    /**
     * @Route("/ajouter", name="ajouter_annonce")
     */
    public function ajouter(Request $request)
    {
        $immobilier =new Immobilier();
        $form=$this->createForm(ImmobilierType ::class ,$immobilier);
        $form->handleRequest($request);
        if ($form ->isSubmitted() && $form->isValid()){

            $ImageFile = $form['imagef']->getData();
            if ($ImageFile) {
                $originalFilename = pathinfo($ImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
          //     $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = md5(uniqid()).'-'.'.'.$ImageFile->guessExtension();
                try {
                    $ImageFile->move(
                        $this->getParameter('Images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $immobilier->setImage($newFilename);
            }

            $this->em->persist($immobilier);
            $this->em->flush();
            $this->addFlash('succes','succes d ajout');

            return $this->redirectToRoute('home');
        }
        return $this->render('immeuble/new.html.twig',
            [
               // 'immobilier'=>$immobilier,
                'form'=>$form->createView(),
            ]);
    }
}
