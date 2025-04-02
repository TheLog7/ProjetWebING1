<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Entity\ReservationLivre;
use App\Form\ReservationLivreType;

class LivreAjoutController extends AbstractController
{
    #[Route('/bibliotheque/livre/ajout', name: 'app_livre_ajout')]
    public function ajouterLivre(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('app_bibliotheque');
        }

        return $this->render('livre/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/bibliotheque/livre/{id}', name: 'app_livre_informations')]
    public function afficherInformations(int $id, EntityManagerInterface $entityManager): Response
    {
        $livre = $entityManager->getRepository(Livre::class)->find($id);

        if (!$livre) {
            throw $this->createNotFoundException('Livre non trouvé.');
        }

        return $this->render('livre/informations.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/bibliotheque/livre/supprimer/{id}', name: 'app_livre_supprimer')]
public function supprimerLivre(int $id, EntityManagerInterface $entityManager): Response
{
    $livre = $entityManager->getRepository(Livre::class)->find($id);

    if (!$livre) {
        throw $this->createNotFoundException('Livre non trouvé.');
    }

    $entityManager->remove($livre);
    $entityManager->flush();

    return $this->redirectToRoute('app_bibliotheque');
}

#[Route('/bibliotheque/recherche', name: 'app_livre_recherche')]
public function recherche(Request $request, EntityManagerInterface $entityManager): Response
{
    $query = $request->query->get('q');

    $livres = [];
    if ($query) {
        $livres = $entityManager->getRepository(Livre::class)->createQueryBuilder('l')
            ->where('l.titre LIKE :query OR l.nom_auteur LIKE :query OR l.genre LIKE :query')
            ->setParameter('query', "%$query%")
            ->getQuery()
            ->getResult();
    }

    return $this->render('livre/recherche.html.twig', [
        'livres' => $livres,
        'query' => $query,
    ]);
}
#[Route('/livre/emprunt/{id}', name: 'app_livre_emprunt')]
public function emprunter(Livre $livre, Request $request, EntityManagerInterface $entityManager): Response
{
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_login');
    }

    $user = $this->getUser(); // Récupérer l'utilisateur connecté

    $reservation = new ReservationLivre();
    $reservation->setLivre($livre);
    $reservation->setUtilisateur($user);
    $reservation->setDateEmprunt(new \DateTime());

    $form = $this->createForm(ReservationLivreType::class, $reservation);
    $form->handleRequest($request);

    // Vérification de la date de retour avant de valider l'emprunt
    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer la date de retour prévue depuis le formulaire
        $dateRetourPrevu = $reservation->getDateRetour();

        // Vérifier si la date de retour est antérieure à la date actuelle
        if ($dateRetourPrevu && $dateRetourPrevu < new \DateTime()) {
            $this->addFlash('error', 'La date de retour ne peut pas être antérieure à la date actuelle.');

            return $this->render('livre/emprunt.html.twig', [
                'form' => $form->createView(),
                'livre' => $livre,
            ]);
        }

        // Si la date de retour est valide, procéder à l'emprunt
        $livre->setDisponible(false);

        $livre->incrementNombreEmprunts();

        // Incrémenter les points de l'utilisateur
        $user->setPoints($user->getPoints() + 1);

        // Vérifier si le niveau doit être mis à jour
        if ($user->getPoints() == 30) {
            $user->setNiveau(2);
        } elseif ($user->getPoints() == 80) {
            $user->setNiveau(3);
        }

        // Mettre à jour la session avec le nouveau nombre de points
        $session = $request->getSession();
        $userData = $session->get('user_data', []);
        $userData['points'] = $user->getPoints(); // Mise à jour
        $userData['niveau'] = $user->getNiveau();
        $session->set('user_data', $userData);

        // Persister les changements
        $entityManager->persist($reservation);
        $entityManager->persist($user); // Mise à jour des points de l'utilisateur
        $entityManager->persist($livre);
        $entityManager->flush();

        // Ajouter un message flash de succès
        $this->addFlash('success', 'Livre emprunté avec succès ! Vous avez gagné 1 point.');
        return $this->redirectToRoute('app_bibliotheque');
    }

    return $this->render('livre/emprunt.html.twig', [
        'form' => $form->createView(),
        'livre' => $livre,
    ]);
}


    
}
