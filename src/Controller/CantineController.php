<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MenuRepository;
use App\Repository\ReservationRepository;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


final class CantineController extends AbstractController
{
    #[Route('/cantine', name: 'app_cantine')]
    public function index(MenuRepository $menuRepository, ReservationRepository $reservationsRepository): Response
    {
        $menus = $menuRepository->findAll();
        $reservations = $reservationsRepository->findAll();
        // Convertir les réservations en un tableau de dates formatées


        return $this->render('cantine/index.html.twig', [
            'controller_name' => 'CantineController',
            'menus' => $menus,
            'reservations' => $reservations
        ]);
    }


    #[Route('/reserve', name: 'reserve_menu', methods: ['POST'])]
    public function reserveMenu(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): JsonResponse
    {
        $date = $request->request->get('date');
        $user = $this->getUser();
        if (!$user) {
            throw new AccessDeniedException('Vous devez être connecté pour effectuer une réservation.');
        }

        // Vérifie si la date est déjà réservée
        $existingReservation = $reservationRepository->findOneBy(['date' => new \DateTime($date), 'user' => $user]);
        if ($existingReservation) {
            return new JsonResponse(['error' => 'This date is already reserved.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Crée une nouvelle réservation
        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setDate(new \DateTime($date));

        $entityManager->persist($reservation);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Reservation confirmed for ' . $date]);
    }


   // CantineController.php

#[Route('/unreserve', name: 'unreserve_menu', methods: ['POST'])]
public function unreserveMenu(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): JsonResponse
{
    $date = $request->request->get('date');
    $user = $this->getUser(); // Assure-toi que l'utilisateur est connecté

    // Trouve la réservation à supprimer
    $reservation = $reservationRepository->findOneBy(['date' => new \DateTime($date), 'user' => $user]);
    if ($reservation) {
        $entityManager->remove($reservation);
        $entityManager->flush();
        return new JsonResponse(['success' => 'Déréservation confirmée pour ' . $date]);
    } else {
        return new JsonResponse(['error' => 'Aucune réservation trouvée pour cette date.'], JsonResponse::HTTP_BAD_REQUEST);
    }
}

}
