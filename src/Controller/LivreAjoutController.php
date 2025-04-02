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

    $user = $this->getUser(); 
    $reservation = new ReservationLivre();
    $reservation->setLivre($livre);
    $reservation->setUtilisateur($user);
    $reservation->setDateEmprunt(new \DateTime());

    $form = $this->createForm(ReservationLivreType::class, $reservation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $dateRetourPrevu = $reservation->getDateRetour();

        if ($dateRetourPrevu && $dateRetourPrevu < new \DateTime()) {
            $this->addFlash('error', 'La date de retour ne peut pas être antérieure à la date actuelle.');

            return $this->render('livre/emprunt.html.twig', [
                'form' => $form->createView(),
                'livre' => $livre,
            ]);
        }

        $livre->setDisponible(false);

        $livre->incrementNombreEmprunts();

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

        $entityManager->persist($reservation);
        $entityManager->persist($user); 
        $entityManager->persist($livre);
        $entityManager->flush();

        $this->addFlash('success', 'Livre emprunté avec succès ! Vous avez gagné 1 point.');
        return $this->redirectToRoute('app_bibliotheque');
    }

    return $this->render('livre/emprunt.html.twig', [
        'form' => $form->createView(),
        'livre' => $livre,
    ]);
}


    
}
