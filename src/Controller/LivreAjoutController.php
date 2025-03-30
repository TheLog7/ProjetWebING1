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

    $reservation = new ReservationLivre();
    $reservation->setLivre($livre);
    $reservation->setUtilisateur($this->getUser());
    $reservation->setDateEmprunt(new \DateTime());

    $form = $this->createForm(ReservationLivreType::class, $reservation);
    $form->handleRequest($request);

    // Vérification de la date de retour avant de valider l'emprunt
    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer la date de retour prévue depuis le formulaire
        $dateRetourPrevu = $reservation->getDateRetour();

        // Vérifier si la date de retour est antérieure à la date actuelle
        if ($dateRetourPrevu && $dateRetourPrevu < new \DateTime()) {
            // Ajouter un message flash pour informer l'utilisateur
            $this->addFlash('error', 'La date de retour ne peut pas être antérieure à la date actuelle.');

            // Retourner à la même page sans persister la réservation
            return $this->render('livre/emprunt.html.twig', [
                'form' => $form->createView(),
                'livre' => $livre,
            ]);
        }

        // Si la date de retour est valide, procéder à l'emprunt
        $livre->setDisponible(false);
        $entityManager->persist($reservation);
        $entityManager->flush();

        // Ajouter un message flash de succès
        $this->addFlash('success', 'Livre emprunté avec succès !');
        return $this->redirectToRoute('app_bibliotheque');
    }

    return $this->render('livre/emprunt.html.twig', [
        'form' => $form->createView(),
        'livre' => $livre,
    ]);
}

    
}
