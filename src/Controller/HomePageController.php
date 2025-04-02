<?php

namespace App\Controller;

use App\Entity\Livre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ReservationLivreRepository; 
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
use App\Entity\Utilisateur;



final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    #[Route('/bibliotheque', name: 'app_bibliotheque')]
public function recherche(LivreRepository $livreRepository, Request $request): Response
{
    $q = $request->query->get('q'); 
    $disponibilite = $request->query->get('disponibilite'); 
    $tri_date = $request->query->get('tri_date'); 

    $qb = $livreRepository->createQueryBuilder('l');

    if (!empty($q)) {
        $qb->andWhere('l.titre LIKE :q')
           ->setParameter('q', '%' . $q . '%');
    }

    if ($disponibilite !== null && $disponibilite !== '') {
        $qb->andWhere('l.disponible = :disponibilite')
           ->setParameter('disponibilite', (bool) $disponibilite);
    }

    if ($tri_date === 'desc') {
        $qb->orderBy('l.date_publication', 'DESC');
    }

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
    $user = $this->getUser();

    if ($user) {
        $reservationsLivres = $reservationLivreRepository->findBy(['utilisateur' => $user]);

        $reservationsOrdinateurs = $reservationOrdinateurRepository->findBy(['utilisateur' => $user]);

        $reservationsJeux = $reservationJeuxRepository->findBy(['utilisateur' => $user]);
        $reservationsVelos = $reservationVeloRepository->findBy(['utilisateur' => $user]);
        $reservationsTrottinettes =$reservationTrottinetteRepository->findBy(['utilisateur' => $user]);

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

    return $this->redirectToRoute('app_login');
}



    #[Route("/reservation/livre/{id}/annuler", name: "app_reservation_annuler")]
    public function annulerReservationLivre(ReservationLivre $reservationLivre, EntityManagerInterface $entityManager): RedirectResponse
    {
        $livre = $reservationLivre->getLivre();
    
        $livre->setDisponible(true);  
    
        $entityManager->persist($livre);
    
        $entityManager->remove($reservationLivre);
        $entityManager->flush();
    
        $this->addFlash('success', 'Réservation de livre annulée avec succès !');
    
        return $this->redirectToRoute('app_reservations');
    }
    

    #[Route('/reservations/ordinateur/{id}/supprimer', name: 'app_reservation_annuler_ordinateur')]
    public function annulerReservationOrdinateur(ReservationOrdinateur $reservationOrdinateur, EntityManagerInterface $entityManager): RedirectResponse
    {
        $ordinateur = $reservationOrdinateur->getOrdinateur();

        $ordinateur->setStatus('Disponible');
        
        $entityManager->persist($ordinateur);


        $entityManager->remove($reservationOrdinateur);

        $entityManager->flush();

        $this->addFlash('success', 'Réservation d\'ordinateur annulée avec succès et l\'ordinateur est maintenant disponible!');

        return $this->redirectToRoute('app_reservations');
    }

    #[Route('/reservations/jeux/{id}/supprimer', name: 'app_reservation_annuler_jeux')]
public function annulerReservationJeux(ReservationJeux $reservationJeux, EntityManagerInterface $entityManager): RedirectResponse
{
    $entityManager->remove($reservationJeux);
    $entityManager->flush();

    return $this->redirectToRoute('app_reservations');
}


#[Route('/reservations/velo/{id}/supprimer', name: 'app_reservation_annuler_velo')]
public function annulerReservationVelo(ReservationVelo $reservationVelo, EntityManagerInterface $entityManager): RedirectResponse
{
    $velo = $reservationVelo->getVelo();

    $velo->setStatut('Disponible');

    $entityManager->persist($velo);

    $entityManager->remove($reservationVelo);

    $entityManager->flush();

    $this->addFlash('success', 'Réservation de vélo annulée avec succès et le vélo est maintenant disponible!');

    return $this->redirectToRoute('app_reservations');
}



#[Route('/reservations/trottinette/{id}/supprimer', name: 'app_reservation_annuler_trottinette')]
public function annulerReservationTrottinette(ReservationTrottinette $reservationTrottinette, EntityManagerInterface $entityManager): RedirectResponse
{
    $trottinette = $reservationTrottinette->getTrottinette();

    $trottinette->setStatut('Disponible');

    $entityManager->persist($trottinette);

    $entityManager->remove($reservationTrottinette);

    $entityManager->flush();

    $this->addFlash('success', 'Réservation de trottinette annulée avec succès et la trottinette est maintenant disponible!');

    return $this->redirectToRoute('app_reservations');
}

#[Route('/utilisateurs/recherche', name: 'app_utilisateur_recherche')]
public function rechercheUtilisateur(Request $request, EntityManagerInterface $entityManager): Response
{
    $query = $request->query->get('q');

    $utilisateurs = [];
    if ($query) {
        $utilisateurs = $entityManager->getRepository(Utilisateur::class)->createQueryBuilder('u')
            ->where('u.nom LIKE :query OR u.prenom LIKE :query')
            ->setParameter('query', "%$query%")
            ->getQuery()
            ->getResult();
    }

    return $this->render('utilisateur/index.html.twig', [
        'utilisateurs' => $utilisateurs,
        'query' => $query,
    ]);
}


}
