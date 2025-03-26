<?php

namespace App\Controller;

use App\Entity\Livre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    // Route pour la page d'accueil
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    // Route pour la page Bibliothèque avec affichage des livres
    #[Route('/bibliotheque', name: 'app_bibliotheque')]
    public function bibliotheque(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les livres depuis la BDD
        $livres = $entityManager->getRepository(Livre::class)->findAll();

        return $this->render('bibliotheque/index.html.twig', [
            'livres' => $livres,
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
