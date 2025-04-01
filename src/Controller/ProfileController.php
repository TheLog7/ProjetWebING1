<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UtilisateurRepository;

final class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'app_profile_details')]
public function profile(Request $request, UtilisateurRepository $utilisateurRepository): Response
{
    $userData = $request->getSession()->get('user_data', []);

    if (empty($userData) || !isset($userData['email'])) {
        return $this->redirectToRoute('app_login');
    }

    // Récupérer l'utilisateur depuis la base de données
    $user = $utilisateurRepository->findOneBy(['email' => $userData['email']]);

    if (!$user) {
        return $this->redirectToRoute('app_login');
    }

    return $this->render('profile/index.html.twig', [
        'user' => $user, // Maintenant c'est un objet Utilisateur
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
    #[Route('/profile/edit-password', name: 'app_edit_password')]
    public function editPassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof PasswordAuthenticatedUserInterface) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createFormBuilder()
            ->add('current_password', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('new_password', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'mapped' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier',
                'attr' => ['class' => 'btn btn-primary mt-2']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('current_password')->getData();
            $newPassword = $form->get('new_password')->getData();

            // Vérifier si le mot de passe actuel est correct
            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('danger', 'Mot de passe actuel incorrect.');
                return $this->redirectToRoute('app_edit_password');
            }

            // Hacher le nouveau mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès.');
            return $this->redirectToRoute('app_profile_details');
        }

        return $this->render('profile/edit_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
