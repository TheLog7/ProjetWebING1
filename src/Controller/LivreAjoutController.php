<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Livre;
use App\Form\LivreType;

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
    
}
