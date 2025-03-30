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
use Symfony\Component\HttpFoundation\RedirectResponse;


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
    ReservationOrdinateurRepository $reservationOrdinateurRepository
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

        // Combine les deux listes de réservations
        $reservations = [
            'livres' => $reservationsLivres,
            'ordinateurs' => $reservationsOrdinateurs,
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
