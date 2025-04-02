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
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $menus = $menuRepository->findAll();
        $reservations = $reservationsRepository->findAll();


        return $this->render('cantine/index.html.twig', [
            'controller_name' => 'CantineController',
            'menus' => $menus,
            'reservations' => $reservations
        ]);
    }


    #[Route('/reserve', name: 'reserve_menu', methods: ['POST'])]
    public function reserveMenu(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): JsonResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $date = $request->request->get('date');
        $user = $this->getUser();
        if (!$user) {
            throw new AccessDeniedException('Vous devez être connecté pour effectuer une réservation.');
        }

        $existingReservation = $reservationRepository->findOneBy(['date' => new \DateTime($date), 'user' => $user]);
        if ($existingReservation) {
            return new JsonResponse(['error' => 'This date is already reserved.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setDate(new \DateTime($date));

        $entityManager->persist($reservation);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Reservation confirmed for ' . $date]);
    }



#[Route('/unreserve', name: 'unreserve_menu', methods: ['POST'])]
public function unreserveMenu(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): JsonResponse
{
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_home_page');
    }
    $date = $request->request->get('date');
    $user = $this->getUser(); 
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
