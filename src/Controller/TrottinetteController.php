<?php

namespace App\Controller;

use App\Entity\Trottinette;
use App\Form\TrottinetteType;
use App\Repository\TrottinetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\ReservationTrottinette;

class TrottinetteController extends AbstractController
{
    #[Route('/trottinettes', name: 'app_trottinette')]
    public function index(Request $request, TrottinetteRepository $trottinetteRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $status = $request->query->get('status');

        if ($status) {
            $trottinettes = $trottinetteRepository->findBy(['statut' => $status]);
        } else {
            $trottinettes = $trottinetteRepository->findAll();
        }

        return $this->render('trottinette/index.html.twig', [
            'trottinettes' => $trottinettes,
        ]);
    }

    #[Route('/trottinettes/ajout', name: 'app_trottinette_ajout')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $trottinette = new Trottinette();
        $form = $this->createForm(TrottinetteType::class, $trottinette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trottinette);
            $entityManager->flush();

            $this->addFlash('success', 'Trottinette ajoutée avec succès !');
            return $this->redirectToRoute('app_trottinette');
        }

        return $this->render('trottinette/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/trottinettes/{id}', name: 'app_trottinette_details', requirements: ['id' => '\d+'])]
    public function details(Trottinette $trottinette): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->render('trottinette/details.html.twig', [
            'trottinette' => $trottinette,
        ]);
    }

    #[Route('/trottinette/{id}/supprimer', name: 'app_trottinette_supprimer')]
    public function supprimer(Trottinette $trottinette, EntityManagerInterface $entityManager): RedirectResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        if ($this->getUser()->getType() === 'Administration' || $this->getUser()->getNiveau() === 3) {
            $entityManager->remove($trottinette);
            $entityManager->flush();

            $this->addFlash('success', 'Trottinette supprimée avec succès !');
        } else {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer cette trottinette.');
        }

        return $this->redirectToRoute('app_trottinette');
    }

    #[Route('/trottinette/{id}/reserver', name: 'app_trottinette_reserver')]
    public function reserver(Trottinette $trottinette, EntityManagerInterface $entityManager): RedirectResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour réserver une trottinette.');
            return $this->redirectToRoute('app_login');
        }
        if ($trottinette->getStatut() !== 'Disponible') {
            $this->addFlash('error', 'Cette trottinette n\'est pas disponible pour réservation.');
            return $this->redirectToRoute('app_trottinette_details', ['id' => $trottinette->getId()]);
        }

        $reservation = new ReservationTrottinette();
        $reservation->setTrottinette($trottinette);
        $reservation->setUtilisateur($this->getUser());
        $reservation->setDateReservation(new \DateTime());

        $user->setPoints($user->getPoints() + 1);

        if ($user->getPoints() == 30) {
            $user->setNiveau(2);
        } elseif ($user->getPoints() == 80) {
            $user->setNiveau(3);
        }

        $session = $request->getSession();
        $userData = $session->get('user_data', []);
        $userData['points'] = $user->getPoints(); 
        $userData['niveau'] = $user->getNiveau();
        $session->set('user_data', $userData);

        $trottinette->setStatut('Indisponible');
        $trottinette->incrementNombreEmprunts();

        $entityManager->persist($reservation);
        $entityManager->persist($user); 
        $entityManager->persist($trottinette);
        $entityManager->flush();

        $this->addFlash('success', 'Trottinette réservée avec succès !');
        return $this->redirectToRoute('app_trottinette_details', ['id' => $trottinette->getId()]);
    }



}
