<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class CoursController extends AbstractController
{
    
     //Affiche l'emploi du temps selon le rôle de l'utilisateur connecté.
     
    #[Route('/cours', name: 'app_cours')]
    public function Cours(CoursRepository $coursRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException("Utilisateur non connecté.");
        }

        if ($user->getType() === 'Enseignant') {
            // Récupérer les cours de l'enseignant
            $cours = $coursRepository->findBy(['enseignant' => $user]);

            return $this->render('cours/index.html.twig', [
                'cours' => $cours,
            ]);
        }

        if ($user->getType() === 'Eleve') {
            // Récupérer les cours de la classe de l'élève
            $cours = $coursRepository->findBy(['classe' => $user->getClasse()]);

            return $this->render('cours/index.html.twig', [
                'cours' => $cours,
            ]);
        }

        return $this->redirectToRoute('app_home_page'); 
    }
}
