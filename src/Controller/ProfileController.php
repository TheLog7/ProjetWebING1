<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class ProfileController extends AbstractController
{

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
    #[Route('/profile/edit-email', name: 'app_edit_email')]
    public function editEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirection si l'utilisateur n'est pas connecté
        }

        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class, [
                'label' => 'Nouvel email',
                'attr' => ['class' => 'form-control']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier',
                'attr' => ['class' => 'btn btn-primary mt-2']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $session = $request->getSession();
            $userData = $session->get('user_data', []);
            $userData['email'] = $user->getEmail();
            $session->set('user_data', $userData);
            $this->addFlash('success', 'Email mis à jour avec succès.');
            return $this->redirectToRoute('app_profile_details');
        }

        return $this->render('profile/edit_email.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
