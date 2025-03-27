<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class ProfileController extends AbstractController
{
    /*#[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }*/

    #[Route('/profile', name: 'app_profile_details')]
    public function profile(Request $request): Response
    {
        // Récupérer les données utilisateur depuis la session
        $userData = $request->getSession()->get('user_data', []);

        // Vérifier si les données sont présentes
        if (empty($userData)) {
            return $this->redirectToRoute('app_login');  // Si aucune donnée n'est trouvée, rediriger vers la page de login
        }

        // Passer les données utilisateur au template
        return $this->render('profile/index.html.twig', [
            'user' => $userData,  // transmettre les données à Twig
        ]);
    }
}
