<?php

namespace App\Controller;

use App\Entity\Ordinateur;
use App\Form\OrdinateurType;
use App\Repository\OrdinateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use App\Entity\ReservationOrdinateur;
use Symfony\Component\Security\Core\User\UserInterface;



class OrdinateurController extends AbstractController
{
    #[Route('/ordinateurs', name: 'app_ordinateur')]
public function index(Request $request, OrdinateurRepository $ordinateurRepository): Response
{
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_home_page');
    }
    $status = $request->query->get('status');
    
    if ($status) {
        $ordinateurs = $ordinateurRepository->findBy(['status' => $status]);
    } else {
        $ordinateurs = $ordinateurRepository->findAll();
    }

    return $this->render('ordinateur/index.html.twig', [
        'ordinateurs' => $ordinateurs,
    ]);
}

    #[Route('/ordinateurs/ajout', name: 'app_ordinateur_ajout')]
public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
{
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_home_page');
    }
    $ordinateur = new Ordinateur();

    $form = $this->createForm(OrdinateurType::class, $ordinateur);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($ordinateur);
        $entityManager->flush();

        $this->addFlash('success', 'Ordinateur ajouté avec succès !');

        return $this->redirectToRoute('app_ordinateur');
    }

    return $this->render('ordinateur/ajout.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/ordinateurs/{id}', name: 'app_ordinateur_details', requirements: ['id' => '\d+'])]
public function details(Ordinateur $ordinateur): Response
{
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_home_page');
    }
    return $this->render('ordinateur/details.html.twig', [
        'ordinateur' => $ordinateur,
    ]);
}

#[Route('/ordinateur/{id}/supprimer', name: 'app_ordinateur_supprimer')]
public function supprimer(Ordinateur $ordinateur, EntityManagerInterface $entityManager): RedirectResponse
{
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_home_page');
    }
    if ($this->getUser()->getType() === 'Administration' || $this->getUser()->getNiveau() === 3) {
        $entityManager->remove($ordinateur); 
        $entityManager->flush(); 
        $this->addFlash('success', 'Ordinateur supprimé avec succès !');
    } else {
        $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer cet ordinateur.');
    }

    return $this->redirectToRoute('app_ordinateur');
}

#[Route('/ordinateur/{id}/reserver', name: 'app_ordinateur_reserver')]
public function reserver(Ordinateur $ordinateur, EntityManagerInterface $entityManager, Request $request): RedirectResponse
{
    if ($ordinateur->getStatus() !== 'Disponible') {
        $this->addFlash('error', 'Cet ordinateur n\'est pas disponible pour réservation.');
        return $this->redirectToRoute('app_ordinateur_details', ['id' => $ordinateur->getId()]);
    }

    $user = $this->getUser();
    if (!$user) {
        $this->addFlash('error', 'Vous devez être connecté pour réserver un ordinateur.');
        return $this->redirectToRoute('app_login');
    }

    $reservation = new ReservationOrdinateur();
    $reservation->setOrdinateur($ordinateur);
    $reservation->setUtilisateur($user);
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

    $ordinateur->setStatus('Indisponible');
    $ordinateur->incrementNombreEmprunts();

    $entityManager->persist($reservation);
    $entityManager->persist($user); 
    $entityManager->persist($ordinateur);
    $entityManager->flush();

    $this->addFlash('success', 'Ordinateur réservé avec succès !');
    return $this->redirectToRoute('app_ordinateur_details', ['id' => $ordinateur->getId()]);
}

}


