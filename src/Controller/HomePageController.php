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
    public function bibliotheque(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les livres depuis la BDD
        $livres = $entityManager->getRepository(Livre::class)->findAll();

        return $this->render('bibliotheque/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    
    #[Route("/reservations", name:"app_reservations")]
    public function showReservations(ReservationLivreRepository $reservationLivreRepository)
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        // Vérifie si l'utilisateur est connecté
        if ($user) {
            // Récupère toutes les réservations de l'utilisateur
            $reservations = $reservationLivreRepository->findBy(['utilisateur' => $user]);

            return $this->render('reservations/index.html.twig', [
                'reservations' => $reservations,
            ]);
        }

        // Si l'utilisateur n'est pas connecté, redirige-le ou affiche un message
        return $this->redirectToRoute('app_login');  // Exemple de redirection vers la page de login
    }

    #[Route('/reservations/annuler/{id}', name: 'app_reservation_annuler')]
    public function annulerReservation(
        $id, 
        ReservationLivreRepository $reservationLivreRepository, 
        LivreRepository $livreRepository, 
        EntityManagerInterface $entityManager
    ) {
        // Récupérer la réservation par ID
        $reservation = $reservationLivreRepository->find($id);

        if ($reservation) {
            // Récupérer le livre associé à la réservation
            $livre = $reservation->getLivre();

            // Rétablir la disponibilité du livre
            $livre->setDisponible(true);

            // Supprimer la réservation
            $entityManager->remove($reservation);

            // Mettre à jour les entités dans la base de données
            $entityManager->flush();

            // Ajouter un message flash de succès
            $this->addFlash('success', 'Réservation annulée avec succès !');
        } else {
            $this->addFlash('error', 'Réservation non trouvée.');
        }

        return $this->redirectToRoute('app_reservations'); // Redirige vers la liste des réservations
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
