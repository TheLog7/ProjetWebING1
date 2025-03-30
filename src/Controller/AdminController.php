<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Livre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\UtilisateurType;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/utilisateurs', name: 'admin_utilisateurs')]
    public function listeUtilisateurs(EntityManagerInterface $entityManager): Response
    {
        $utilisateurs = $entityManager->getRepository(Utilisateur::class)->findAll();

        return $this->render('admin/utilisateurs.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/admin/livres', name: 'admin_livres')]
    public function listeLivres(EntityManagerInterface $entityManager): Response
    {
        $livres = $entityManager->getRepository(Livre::class)->findAll();

        return $this->render('admin/livres.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/admin/utilisateur/modifier/{id}', name: 'admin_utilisateur_modifier')]
    public function modifierUtilisateur(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération de l'utilisateur
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Vérification des permissions (optionnel)
        if ($this->getUser()->getNiveau() < 3) {
            throw new AccessDeniedException("Vous n'avez pas les droits pour modifier cet utilisateur.");
        }

        // Création du formulaire
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion du mot de passe (ne pas écraser si laissé vide)
            if ($form->get('motDePasse')->getData()) {
                $utilisateur->setMotDePasse(password_hash($form->get('motDePasse')->getData(), PASSWORD_BCRYPT));
            }

            // Gestion de la photo
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $newFilename = uniqid().'.'.$photoFile->guessExtension();
                $photoFile->move($this->getParameter('photo_directory'), $newFilename);
                $utilisateur->setPhoto('uploads/photos/'.$newFilename);
            }

            // Enregistrement des modifications
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'Utilisateur modifié avec succès.');

            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/modifier_utilisateur.html.twig', [
            'form' => $form->createView(),
            'utilisateur' => $utilisateur
        ]);
    }

    #[Route('/admin/utilisateur/supprimer/{id}', name: 'admin_utilisateur_supprimer', methods: ['POST'])]
public function supprimerUtilisateur(int $id, EntityManagerInterface $entityManager, Request $request): Response
{
    $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($id);

    if (!$utilisateur) {
        throw $this->createNotFoundException("Utilisateur non trouvé");
    }

    // Vérification du token CSRF pour plus de sécurité
    if ($this->isCsrfTokenValid('supprimer_utilisateur_'.$id, $request->request->get('_token'))) {
        $entityManager->remove($utilisateur);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur supprimé avec succès.');
    } else {
        $this->addFlash('error', 'Token CSRF invalide, suppression annulée.');
    }

    return $this->redirectToRoute('app_home_page');
}

}
