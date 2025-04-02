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
    
     
    #[Route('/cours', name: 'app_cours')]
    public function Cours(CoursRepository $coursRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $user = $this->getUser();


        if ($user->getType() === 'Enseignant') {
            $cours = $coursRepository->findBy(['enseignant' => $user]);

            return $this->render('cours/index.html.twig', [
                'cours' => $cours,
            ]);
        }

        if ($user->getType() === 'Eleve') {
            $cours = $coursRepository->findBy(['classe' => $user->getClasse()]);

            return $this->render('cours/index.html.twig', [
                'cours' => $cours,
            ]);
        }

        return $this->redirectToRoute('app_home_page'); 
    }
}
