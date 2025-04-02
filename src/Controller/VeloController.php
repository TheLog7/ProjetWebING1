<?php

namespace App\Controller;

use App\Entity\Velo;
use App\Form\VeloType;
use App\Repository\VeloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\ReservationVelo;

class VeloController extends AbstractController
{
    #[Route('/velos', name: 'app_velo')]
    public function index(Request $request, VeloRepository $veloRepository): Response
    {
        $status = $request->query->get('status');

        if ($status) {
            $velos = $veloRepository->findBy(['statut' => $status]);
        } else {
            $velos = $veloRepository->findAll();
        }

        return $this->render('velo/index.html.twig', [
            'velos' => $velos,
        ]);
    }

    #[Route('/velos/ajout', name: 'app_velo_ajout')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $velo = new Velo();
        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($velo);
            $entityManager->flush();

            $this->addFlash('success', 'Vélo ajouté avec succès !');
            return $this->redirectToRoute('app_velo');
        }

        return $this->render('velo/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/velos/{id}', name: 'app_velo_details', requirements: ['id' => '\d+'])]
    public function details(Velo $velo): Response
    {
        return $this->render('velo/details.html.twig', [
            'velo' => $velo,
        ]);
    }

    #[Route('/velo/{id}/supprimer', name: 'app_velo_supprimer')]
    public function supprimer(Velo $velo, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($this->getUser()->getType() === 'Administration' || $this->getUser()->getNiveau() === 3) {
            $entityManager->remove($velo);
            $entityManager->flush();

            $this->addFlash('success', 'Vélo supprimé avec succès !');
        } else {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer ce vélo.');
        }

        return $this->redirectToRoute('app_velo');
    }

    #[Route('/velo/{id}/reserver', name: 'app_velo_reserver')]
    public function reserver(Velo $velo, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour réserver une trottinette.');
            return $this->redirectToRoute('app_login');
        }
        if ($velo->getStatut() !== 'Disponible') {
            $this->addFlash('error', 'Ce vélo n\'est pas disponible pour réservation.');
            return $this->redirectToRoute('app_velo_details', ['id' => $velo->getId()]);
        }

        $reservation = new ReservationVelo();
        $reservation->setVelo($velo);
        $reservation->setUtilisateur($this->getUser());
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


        $velo->setStatut('Indisponible');

        $entityManager->persist($reservation);
        $entityManager->persist($user); // Mettre à jour l'utilisateur
        $entityManager->persist($velo);
        $entityManager->flush();

        $this->addFlash('success', 'Vélo réservé avec succès !');
        return $this->redirectToRoute('app_velo_details', ['id' => $velo->getId()]);
    }
}
