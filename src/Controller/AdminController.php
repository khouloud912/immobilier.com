<?php

namespace App\Controller;

use App\Entity\Immobilier;
use App\Entity\User;
use App\Repository\ImmobilierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{

    private $em;
    //cette fonction permet de creer une instance de l'entity manager
    public function __construct( EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/admin", name="admin")
     */

    //cette fonction permet d'afficher la page twig de l'administrateur
    public function affiche()
    {
        return $this->render('admin/administration.html.twig');
    }

        /**
         * @Route("/admin/user", name="adminUser")
         */

        // cette fonction permet de retourner une page twig qui affiche tous les utilisateurs existant dans la base de donne
    public function index(UserRepository $repository):Response
    {
        $this->repository=$repository;
        $users = $this->repository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users'=>$users
        ]);
    }




        /**
     * @Route("/admin/delete/{id}", name="suppression")
     */
        // cette foction permet de donner l'acces a l'admin pour supprimer un utilisateur
    public function delete( Request $request,User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
        return $this->redirectToRoute('admin');

    }
    /**
     * @Route("/admin/annonces", name="annonces")
     */
    //cette fonction permet a l'administrateur de gerer les annonces
    public function annonces(ImmobilierRepository $repository):Response{
        $etat= 'attente';

        $this->repository=$repository;
        $immob = $this->repository->findbyetat($etat);
        return $this->render('admin/annonces.html.twig', [
            'controller_name' => 'AdminController',
            'immob'=>$immob
        ]);




    }



}
