<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\ReservationJeux;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GameRoomController extends AbstractController
{
    #[Route('/game/room', name: 'app_game_room')]
    public function index(EntityManagerInterface $em): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }        $jeux = $em->getRepository(Jeux::class)->findAll();

        return $this->render('game_room/index.html.twig', [
            'game_objects' => $jeux,
        ]);
    }

    #[Route('/reservations/{id}', name: 'app_reservation', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function manageReservation(Request $request, EntityManagerInterface $em, Jeux $jeu): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        if ($request->isMethod('GET')) {
            $creneaux = $this->generateTimeSlots();
            
            return $this->render('reservations/new.html.twig', [
                'jeu' => $jeu,
                'creneaux' => $creneaux
            ]);
        }
    
        if ($request->isMethod('POST')) {
            $creneau = new \DateTime($request->request->get('creneau'));
            $nbJoueurs = (int) $request->request->get('nb_joueurs');
    
            if ($nbJoueurs > $jeu->getMaxPlaces()) {
                $this->addFlash('error', 'Le nombre de joueurs dépasse la capacité maximale');
                return $this->redirectToRoute('app_reservation', ['id' => $jeu->getId()]);
            }
    
            $reservation = new ReservationJeux();
            $reservation
                ->setJeux($jeu)
                ->setUtilisateur($this->getUser())
                ->setStartTime($creneau)
                ->setEndTime((clone $creneau)->modify('+1 hour'))
                ->setNbJoueurs($nbJoueurs);
    
            $em->persist($reservation);
            $em->flush();
    
            $this->addFlash('success', 'Votre réservation a bien été enregistrée !');
            return $this->redirectToRoute('app_game_room');
        }
    
        throw $this->createNotFoundException('Méthode non supportée.');
    }
    

    private function generateTimeSlots(): array
    {
        $slots = [];
        $start = new \DateTime('now');
        $start->setTime((int) $start->format('H'), 0); 
    
        for ($i = 0; $i < 6; $i++) {
            $end = clone $start;
            $end->modify('+1 hour');
    
            if ($start > new \DateTime('now')) {
                $slots[] = [
                    'start' => $start->format('H:i'),
                    'end' => $end->format('H:i'),
                    'value' => $start->format('Y-m-d\TH:i:s')
                ];
            }
    
            $start->modify('+1 hour');
        }
    
        return $slots;
    }
    
}