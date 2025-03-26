<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController{
    //Route page d'accueil
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    //Route pour la page Blibliothèque
    #[Route('/bibliotheque', name: 'app_bibliotheque')]
    public function bibliotheque(): Response
    {
        return $this->render('bibliotheque/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }


        //Route pour la page Cantine
        #[Route('/cantine', name: 'app_cantine')]
        public function cantine(): Response
        {
            return $this->render('cantine/index.html.twig', [
                'controller_name' => 'HomePageController',
            ]);
        }
    
        //Route pour la page Imprimerie
        #[Route('/imprimerie', name: 'app_imprimerie')]
        public function imprimerie(): Response
        {
            return $this->render('imprimerie/index.html.twig', [
                'controller_name' => 'HomePageController',
            ]);
        }


}
