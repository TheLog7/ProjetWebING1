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
use App\Entity\Ordinateur;
use App\Form\LivreType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Entity\ReservationLivre;
use App\Entity\ReservationOrdinateur;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Process\Process;


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

        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Vérification des permissions (optionnel)
        if ($this->getUser()->getNiveau() < 3) {
            throw new AccessDeniedException("Vous n'avez pas les droits pour modifier cet utilisateur.");
        }

        // Création du formulaire
        // Créer le formulaire en passant l'utilisateur comme option
$form = $this->createForm(UtilisateurType::class, $utilisateur, [
    'current_user' => $user,  // Passer l'utilisateur connecté
]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion du mot de passe (ne pas écraser si laissé vide)
            if ($form->get('motDePasse')->getData()) {
                $utilisateur->setPassword(password_hash($form->get('motDePasse')->getData(), PASSWORD_BCRYPT));
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

#[Route('/admin/objets', name: 'admin_objets')]
    public function objets(EntityManagerInterface $entityManager): Response
    {
        $livres = $entityManager->getRepository(Livre::class)->findAll();
        $ordinateurs = $entityManager->getRepository(Ordinateur::class)->findAll();

        return $this->render('admin/objets.html.twig', [
            'livres' => $livres,
            'ordinateurs' => $ordinateurs,
        ]);
    }

    #[Route('/admin/livre/modifier/{id}', name: 'admin_livre_modifier', methods: ['GET', 'POST'])]
    public function modifierLivre(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = $entityManager->getRepository(Livre::class)->find($id);
    
        if (!$livre) {
            throw $this->createNotFoundException("Livre non trouvé.");
        }
    
        $form = $this->createFormBuilder($livre)
            ->add('titre', TextType::class, ['label' => 'Titre'])
            ->add('nomAuteur', TextType::class, ['label' => 'Nom de l\'auteur'])
            ->add('prenomAuteur', TextType::class, ['label' => 'Prénom de l\'auteur'])
            ->add('datePublication', DateType::class, [
                'label' => 'Date de Publication',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('genre', TextType::class, ['label' => 'Genre'])
            ->add('disponible', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier',
                'attr' => ['class' => 'bg-blue-500 text-white px-4 py-2 rounded-lg']
            ])
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash('success', 'Livre modifié avec succès.');
            return $this->redirectToRoute('admin_objets');
        }
    
        return $this->render('admin/modifier_livre.html.twig', [
            'form' => $form->createView(),
            'livre' => $livre
        ]);
    }
    

    #[Route('/admin/livre/supprimer/{id}', name: 'admin_livre_supprimer', methods: ['POST','GET'])]
public function supprimerLivre(int $id, EntityManagerInterface $entityManager): Response
{
    $livre = $entityManager->getRepository(Livre::class)->find($id);

    if (!$livre) {
        throw $this->createNotFoundException("Livre non trouvé.");
    }

    // Vérifier si le livre a encore des réservations actives
    $reservations = $entityManager->getRepository(ReservationLivre::class)->findBy(['livre' => $livre]);
    
    if (count($reservations) > 0) {
        $this->addFlash('error', 'Impossible de supprimer ce livre : il est encore réservé.');
        return $this->redirectToRoute('admin_objets');
    }

    // Suppression du livre
    $entityManager->remove($livre);
    $entityManager->flush();

    $this->addFlash('success', 'Livre supprimé avec succès.');
    return $this->redirectToRoute('admin_objets');
}

    

#[Route('/admin/ordinateur/modifier/{id}', name: 'admin_ordinateur_modifier', methods: ['GET', 'POST'])]
public function modifierOrdinateur(int $id, Request $request, EntityManagerInterface $entityManager): Response
{
    $ordinateur = $entityManager->getRepository(Ordinateur::class)->find($id);

    if (!$ordinateur) {
        throw $this->createNotFoundException("Ordinateur non trouvé.");
    }

    $form = $this->createFormBuilder($ordinateur)
        ->add('nom', TextType::class, ['label' => 'Nom'])
        ->add('marque', TextType::class, ['label' => 'Marque'])
        ->add('numeroSerie', TextType::class, ['label' => 'Numéro de Série'])
        ->add('status', TextType::class, ['label' => 'Statut'])
        ->add('localisation', TextType::class, ['label' => 'Localisation'])
        ->add('dateAchat', DateType::class, [
            'label' => 'Date d\'Achat',
            'widget' => 'single_text',
            'required' => false
        ])
        ->add('derniereMaintenance', DateType::class, [
            'label' => 'Dernière Maintenance',
            'widget' => 'single_text',
            'required' => false
        ])
        ->add('estEnService', CheckboxType::class, [
            'label' => 'En Service',
            'required' => false
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Modifier',
            'attr' => ['class' => 'bg-blue-500 text-white px-4 py-2 rounded-lg']
        ])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Ordinateur modifié avec succès.');
        return $this->redirectToRoute('admin_objets');
    }

    return $this->render('admin/modifier_ordinateur.html.twig', [
        'form' => $form->createView(),
        'ordinateur' => $ordinateur
    ]);
}


#[Route('/admin/ordinateur/supprimer/{id}', name: 'admin_ordinateur_supprimer', methods: ['POST', 'GET'])]
public function supprimerOrdinateur(int $id, EntityManagerInterface $entityManager): Response
{
    $ordinateur = $entityManager->getRepository(Ordinateur::class)->find($id);

    if (!$ordinateur) {
        throw $this->createNotFoundException("Ordinateur non trouvé.");
    }

    // Vérifier s'il y a des réservations associées à cet ordinateur
    $reservations = $entityManager->getRepository(ReservationOrdinateur::class)->findBy(['ordinateur' => $ordinateur]);

    if (count($reservations) > 0) {
        $this->addFlash('error', 'Impossible de supprimer cet ordinateur : il est encore réservé.');
        return $this->redirectToRoute('admin_objets');
    }

    // Suppression de l'ordinateur
    $entityManager->remove($ordinateur);
    $entityManager->flush();

    $this->addFlash('success', 'Ordinateur supprimé avec succès.');
    return $this->redirectToRoute('admin_objets');
}

#[Route('/admin/backup', name: 'admin_backup', methods: ['POST'])]
public function backupDatabase(): JsonResponse
{
    $date = date('Y-m-d_H-i-s');
    $backupFile = 'var/backups/backup_' . $date . '.sql';  // S'assurer que le chemin est correct

    // Vérifier que le répertoire de sauvegarde existe
    if (!file_exists('var/backups')) {
        mkdir('var/backups', 0777, true);  // Crée le dossier si nécessaire
    }

    // Assurer que le mot de passe est passé sans espace après `-p`
    $process = new Process([
        'mysqldump', 
        '-u', 'root', 
        '-pcytech0001',   // Pas d'espace entre '-p' et le mot de passe
        'College', 
        '-r', $backupFile
    ]);

    // Exécuter la commande
    $process->run();

    // Vérifier si le processus a été réussi
    if (!$process->isSuccessful()) {
        return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de la sauvegarde.'], 500);
    }

    return new JsonResponse(['status' => 'success', 'message' => 'Sauvegarde réussie !']);
}

// Cette route sera déclenchée quand tu appuieras sur le bouton pour vérifier l'intégrité des données
#[Route('/admin/verify-data-integrity', name: 'admin_verify_data_integrity')]
public function verifyDataIntegrity(): JsonResponse
{
    // Exemple de vérification des données
    $repository = $this->getDoctrine()->getRepository(User::class);
    $invalidUsers = $repository->findByInvalidData();  // Suppose que tu as une méthode pour trouver des données corrompues

    if (count($invalidUsers) > 0) {
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Des erreurs d\'intégrité des données ont été trouvées.',
            'invalidUsers' => $invalidUsers,  // Liste des utilisateurs avec erreurs
        ], 400);
    }

    return new JsonResponse([
        'status' => 'success',
        'message' => 'Les données sont intactes.',
    ]);
}


}
