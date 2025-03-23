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

    //Route pour la page de connexion
    #[Route('/page_connexion', name: 'app_login')]
    public function page_connexion(): Response
    {
        return $this->render('page_connexion/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    //Route pour la page d'inscription
    #[Route('/page_inscription', name: 'app_signup')]
    public function page_inscription(): Response
    {
        return $this->render('page_inscription/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

}
