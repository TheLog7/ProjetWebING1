<?php

namespace App\Controller;

use App\Entity\Livre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ReservationLivreRepository;  // Import du bon repository
use App\Repository\LivreRepository;
use App\Entity\ReservationLivre;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationOrdinateurRepository;
use App\Entity\ReservationOrdinateur;
use App\Entity\ReservationJeux;
use App\Repository\ReservationJeuxRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\ReservationVeloRepository;
use App\Entity\ReservationVelo;
use App\Repository\ReservationTrottinetteRepository;
use App\Entity\ReservationTrottinette;




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
public function recherche(LivreRepository $livreRepository, Request $request): Response
{
    // Récupérer les filtres de l'URL
    $q = $request->query->get('q'); // Recherche par titre
    $disponibilite = $request->query->get('disponibilite'); // Disponibilité (1 pour disponible, 0 pour indisponible)
    $tri_date = $request->query->get('tri_date'); // Trier par date de publication

    // Utiliser QueryBuilder pour gérer la recherche et le tri
    $qb = $livreRepository->createQueryBuilder('l');

    // Recherche par titre (LIKE)
    if (!empty($q)) {
        $qb->andWhere('l.titre LIKE :q')
           ->setParameter('q', '%' . $q . '%');
    }

    // Filtre par disponibilité
    if ($disponibilite !== null && $disponibilite !== '') {
        $qb->andWhere('l.disponible = :disponibilite')
           ->setParameter('disponibilite', (bool) $disponibilite);
    }

    // Tri par date de publication
    if ($tri_date === 'desc') {
        $qb->orderBy('l.date_publication', 'DESC');
    }

    // Exécuter la requête
    $livres = $qb->getQuery()->getResult();

    return $this->render('bibliotheque/index.html.twig', [
        'livres' => $livres,
    ]);
}


    
#[Route("/reservations", name:"app_reservations")]
public function showReservations(
    ReservationLivreRepository $reservationLivreRepository,
    ReservationOrdinateurRepository $reservationOrdinateurRepository,
    ReservationJeuxRepository $reservationJeuxRepository,
    ReservationVeloRepository $reservationVeloRepository,
    ReservationTrottinetteRepository $reservationTrottinetteRepository,
    )
{
    // Récupère l'utilisateur connecté
    $user = $this->getUser();

    // Vérifie si l'utilisateur est connecté
    if ($user) {
        // Récupère toutes les réservations de l'utilisateur pour les livres
        $reservationsLivres = $reservationLivreRepository->findBy(['utilisateur' => $user]);

        // Récupère toutes les réservations de l'utilisateur pour les ordinateurs
        $reservationsOrdinateurs = $reservationOrdinateurRepository->findBy(['utilisateur' => $user]);

        // Récupère toutes les réservations de l'utilisateur pour les jeux
        $reservationsJeux = $reservationJeuxRepository->findBy(['utilisateur' => $user]);
        $reservationsVelos = $reservationVeloRepository->findBy(['utilisateur' => $user]);
        $reservationsTrottinettes =$reservationTrottinetteRepository->findBy(['utilisateur' => $user]);

        // Combine les deux listes de réservations
        $reservations = [
            'livres' => $reservationsLivres,
            'ordinateurs' => $reservationsOrdinateurs,
            'jeux' => $reservationsJeux,
            'velos' => $reservationsVelos,
            'trottinettes' => $reservationsTrottinettes,
        ];

        return $this->render('reservations/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    return $this->redirectToRoute('app_login');
}



    // Dans le contrôleur des réservations
    #[Route("/reservation/livre/{id}/annuler", name: "app_reservation_annuler")]
    public function annulerReservationLivre(ReservationLivre $reservationLivre, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Récupérer le livre associé à la réservation
        $livre = $reservationLivre->getLivre();
    
        // Mettre l'attribut 'disponible' du livre sur 1
        $livre->setDisponible(true);  // Assurez-vous que la méthode setDisponible existe dans l'entité Livre
    
        // Sauvegarder le livre avec la mise à jour du statut
        $entityManager->persist($livre);
    
        // Supprimer la réservation
        $entityManager->remove($reservationLivre);
        $entityManager->flush();
    
        // Ajouter un message flash de succès
        $this->addFlash('success', 'Réservation de livre annulée avec succès !');
    
        // Rediriger vers la page des réservations
        return $this->redirectToRoute('app_reservations');
    }
    

    #[Route('/reservations/ordinateur/{id}/supprimer', name: 'app_reservation_annuler_ordinateur')]
    public function annulerReservationOrdinateur(ReservationOrdinateur $reservationOrdinateur, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Récupérer l'ordinateur associé à la réservation
        $ordinateur = $reservationOrdinateur->getOrdinateur();

        // Changer le statut de l'ordinateur à 'disponible'
        $ordinateur->setStatus('disponible');
        
        // Sauvegarder les modifications dans la base de données
        $entityManager->persist($ordinateur);


        // Suppression de la réservation
        $entityManager->remove($reservationOrdinateur);

        // Appliquer les changements
        $entityManager->flush();

        // Ajouter un message flash de succès
        $this->addFlash('success', 'Réservation d\'ordinateur annulée avec succès et l\'ordinateur est maintenant disponible!');

        // Redirige vers la page des réservations
        return $this->redirectToRoute('app_reservations');
    }

    #[Route('/reservations/jeux/{id}/supprimer', name: 'app_reservation_annuler_jeux')]
    public function annulerReservationJeux(ReservationJeux $reservationJeux, EntityManagerInterface $entityManager): RedirectResponse
    {
    
        // Suppression de la réservation
        $entityManager->remove($reservationJeux);

        // Appliquer les changements
        $entityManager->flush();
    }

#[Route('/reservations/velo/{id}/supprimer', name: 'app_reservation_annuler_velo')]
public function annulerReservationVelo(ReservationVelo $reservationVelo, EntityManagerInterface $entityManager): RedirectResponse
{
    // Récupérer le vélo associé à la réservation
    $velo = $reservationVelo->getVelo();

    // Changer le statut du vélo à 'disponible'
    $velo->setStatut('disponible');

    // Sauvegarder les modifications dans la base de données
    $entityManager->persist($velo);

    // Suppression de la réservation
    $entityManager->remove($reservationVelo);

    // Appliquer les changements
    $entityManager->flush();

    // Ajouter un message flash de succès
    $this->addFlash('success', 'Réservation de vélo annulée avec succès et le vélo est maintenant disponible!');

    // Redirige vers la page des réservations
    return $this->redirectToRoute('app_reservations');
}



#[Route('/reservations/trottinette/{id}/supprimer', name: 'app_reservation_annuler_trottinette')]
public function annulerReservationTrottinette(ReservationTrottinette $reservationTrottinette, EntityManagerInterface $entityManager): RedirectResponse
{
    // Récupérer la trottinette associée à la réservation
    $trottinette = $reservationTrottinette->getTrottinette();

    // Changer le statut de la trottinette à 'disponible'
    $trottinette->setStatut('disponible');

    // Sauvegarder les modifications dans la base de données
    $entityManager->persist($trottinette);

    // Suppression de la réservation
    $entityManager->remove($reservationTrottinette);

    // Appliquer les changements
    $entityManager->flush();

    // Ajouter un message flash de succès
    $this->addFlash('success', 'Réservation de trottinette annulée avec succès et la trottinette est maintenant disponible!');

    // Redirige vers la page des réservations
    return $this->redirectToRoute('app_reservations');
}


}
