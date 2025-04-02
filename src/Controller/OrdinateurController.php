<?php

namespace App\Controller;

use App\Entity\Ordinateur;
use App\Form\OrdinateurType;
use App\Repository\OrdinateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse; // Assure-toi de cette importation
use App\Entity\ReservationOrdinateur;
use Symfony\Component\Security\Core\User\UserInterface;



class OrdinateurController extends AbstractController
{
    #[Route('/ordinateurs', name: 'app_ordinateur')]
public function index(Request $request, OrdinateurRepository $ordinateurRepository): Response
{
    // Récupération du statut filtré (disponible ou indisponible)
    $status = $request->query->get('status');
    
    // Filtrer les ordinateurs en fonction du statut
    if ($status) {
        // Si un statut est sélectionné, on filtre les ordinateurs
        $ordinateurs = $ordinateurRepository->findBy(['status' => $status]);
    } else {
        // Sinon, on récupère tous les ordinateurs
        $ordinateurs = $ordinateurRepository->findAll();
    }

    return $this->render('ordinateur/index.html.twig', [
        'ordinateurs' => $ordinateurs,
    ]);
}

    #[Route('/ordinateurs/ajout', name: 'app_ordinateur_ajout')]
public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
{
    // Création de l'entité Ordinateur
    $ordinateur = new Ordinateur();

    // Création du formulaire
    $form = $this->createForm(OrdinateurType::class, $ordinateur);

    // Gestion de la soumission du formulaire
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Persister l'entité
        $entityManager->persist($ordinateur);
        $entityManager->flush();

        // Message flash de succès
        $this->addFlash('success', 'Ordinateur ajouté avec succès !');

        // Redirection vers la liste des ordinateurs
        return $this->redirectToRoute('app_ordinateur');
    }

    // Si le formulaire n'est pas soumis ou valide, on réaffiche la page d'ajout avec les erreurs
    return $this->render('ordinateur/ajout.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/ordinateurs/{id}', name: 'app_ordinateur_details', requirements: ['id' => '\d+'])]
public function details(Ordinateur $ordinateur): Response
{
    return $this->render('ordinateur/details.html.twig', [
        'ordinateur' => $ordinateur,
    ]);
}

#[Route('/ordinateur/{id}/supprimer', name: 'app_ordinateur_supprimer')]
public function supprimer(Ordinateur $ordinateur, EntityManagerInterface $entityManager): RedirectResponse
{
    // Vérification si l'utilisateur est 'Administration' ou a un niveau égal à 3
    if ($this->getUser()->getType() === 'Administration' || $this->getUser()->getNiveau() === 3) {
        $entityManager->remove($ordinateur); // Suppression de l'ordinateur
        $entityManager->flush(); // Appliquer les changements

        $this->addFlash('success', 'Ordinateur supprimé avec succès !');
    } else {
        $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer cet ordinateur.');
    }

    return $this->redirectToRoute('app_ordinateur');
}

#[Route('/ordinateur/{id}/reserver', name: 'app_ordinateur_reserver')]
public function reserver(Ordinateur $ordinateur, EntityManagerInterface $entityManager, Request $request): RedirectResponse
{
    // Vérifier si l'ordinateur est disponible
    if ($ordinateur->getStatus() !== 'Disponible') {
        $this->addFlash('error', 'Cet ordinateur n\'est pas disponible pour réservation.');
        return $this->redirectToRoute('app_ordinateur_details', ['id' => $ordinateur->getId()]);
    }

    // Récupérer l'utilisateur connecté
    $user = $this->getUser();
    if (!$user) {
        $this->addFlash('error', 'Vous devez être connecté pour réserver un ordinateur.');
        return $this->redirectToRoute('app_login');
    }

    // Créer une nouvelle réservation
    $reservation = new ReservationOrdinateur();
    $reservation->setOrdinateur($ordinateur);
    $reservation->setUtilisateur($user);
    $reservation->setDateReservation(new \DateTime());

    // Incrémenter le niveau de l'utilisateur
    $user->setPoints($user->getPoints() + 1);

    // Vérifier si le niveau doit être mis à jour
    if ($user->getPoints() == 30) {
        $user->setNiveau(2);
    } elseif ($user->getPoints() == 80) {
        $user->setNiveau(3);
    }

    // Mettre à jour la session
    $session = $request->getSession();
    $userData = $session->get('user_data', []);
    $userData['points'] = $user->getPoints(); // Mettre à jour avec la nouvelle valeur
    $userData['niveau'] = $user->getNiveau();
    $session->set('user_data', $userData);

    // Mettre à jour le statut de l'ordinateur à "Indisponible"
    $ordinateur->setStatus('Indisponible');
    $ordinateur->incrementNombreEmprunts();

    // Persister les modifications en base de données
    $entityManager->persist($reservation);
    $entityManager->persist($user); // Mettre à jour l'utilisateur
    $entityManager->persist($ordinateur);
    $entityManager->flush();

    $this->addFlash('success', 'Ordinateur réservé avec succès !');
    return $this->redirectToRoute('app_ordinateur_details', ['id' => $ordinateur->getId()]);
}

}


