<?php

namespace App\Controller;

use App\Repository\ImmobilierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repository;


    /**
     * @Route("/", name="home")
     */

    // cette fonction retourne la page initiale de notre projet qui est home page avec les 4 derniere immobilier publié filtre par date
    public function index(ImmobilierRepository $repository):Response
    {
        $this->repository=$repository;
        $user = $this->getUser();
       $immobiliers = $this->repository->findByLatest();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'immobiliers'=>$immobiliers
        ]);
    }
}
