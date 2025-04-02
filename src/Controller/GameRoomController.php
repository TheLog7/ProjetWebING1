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
        // Récupère tous les jeux disponibles
        $jeux = $em->getRepository(Jeux::class)->findAll();

        return $this->render('game_room/index.html.twig', [
            'game_objects' => $jeux,
        ]);
    }

    #[Route('/reservations/{id}', name: 'app_reservation', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function manageReservation(Request $request, EntityManagerInterface $em, Jeux $jeu): Response
    {
        // Si la méthode est GET, on génère les créneaux horaires et on les affiche
        if ($request->isMethod('GET')) {
            $creneaux = $this->generateTimeSlots();
            
            return $this->render('reservations/new.html.twig', [
                'jeu' => $jeu,
                'creneaux' => $creneaux
            ]);
        }
    
        // Si la méthode est POST, on crée la réservation
        if ($request->isMethod('POST')) {
            // Récupération Données Formulaire
            $creneau = new \DateTime($request->request->get('creneau'));
            $nbJoueurs = (int) $request->request->get('nb_joueurs');
    
            // Validation basique
            if ($nbJoueurs > $jeu->getMaxPlaces()) {
                $this->addFlash('error', 'Le nombre de joueurs dépasse la capacité maximale');
                return $this->redirectToRoute('app_reservation', ['id' => $jeu->getId()]);
            }
    
            // Création de la réservation
            $reservation = new ReservationJeux();
            $reservation
                ->setJeux($jeu)
                ->setUtilisateur($this->getUser())
                ->setStartTime($creneau)
                ->setEndTime((clone $creneau)->modify('+1 hour'))
                ->setNbJoueurs($nbJoueurs);
    
                $jeu->incrementNombreEmprunts();
            
            $em->persist($reservation);
            $em->flush();
    
            $this->addFlash('success', 'Votre réservation a bien été enregistrée !');
            return $this->redirectToRoute('app_game_room');
        }
    
        // Si ce n'est ni GET ni POST, on renvoie une erreur (logiquement ce cas ne devrait pas arriver)
        throw $this->createNotFoundException('Méthode non supportée.');
    }
    
    /**
     * Génère des créneaux horaires de 1h à partir de l'heure actuelle
     */
    private function generateTimeSlots(): array
    {
        $slots = [];
        $start = new \DateTime('now');
        $start->setTime((int) $start->format('H'), 0); // Heure ronde (ex: 14:00)
    
        // On propose 6 créneaux de 1h
        for ($i = 0; $i < 6; $i++) {
            $end = clone $start;
            $end->modify('+1 hour');
    
            // On ne propose pas de créneau dans le passé
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