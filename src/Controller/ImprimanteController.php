<?php

namespace App\Controller;

use App\Entity\Imprimante;
use App\Form\ImprimanteType;
use App\Repository\ImprimanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ImprimanteController extends AbstractController
{
    #[Route('/imprimantes', name: 'app_imprimante')]
    public function index(Request $request, ImprimanteRepository $imprimanteRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $imprimantes = $imprimanteRepository->findAll();

        return $this->render('imprimante/index.html.twig', [
            'imprimantes' => $imprimantes,
        ]);
    }

    #[Route('/imprimantes/ajout', name: 'app_imprimante_ajout')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $imprimante = new Imprimante();
        $form = $this->createForm(ImprimanteType::class, $imprimante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($imprimante);
            $entityManager->flush();

            $this->addFlash('success', 'Imprimante ajoutée avec succès !');
            return $this->redirectToRoute('app_imprimante');
        }

        return $this->render('imprimante/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/imprimantes/{id}', name: 'app_imprimante_details', requirements: ['id' => '\d+'])]
    public function details(Imprimante $imprimante): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->render('imprimante/details.html.twig', [
            'imprimante' => $imprimante,
        ]);
    }

    #[Route('/imprimante/{id}/supprimer', name: 'app_imprimante_supprimer')]
    public function supprimer(Imprimante $imprimante, EntityManagerInterface $entityManager): RedirectResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        if ($this->getUser()->getType() === 'Administration' || $this->getUser()->getNiveau() === 3) {
            $entityManager->remove($imprimante);
            $entityManager->flush();

            $this->addFlash('success', 'Imprimante supprimée avec succès !');
        } else {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer cette imprimante.');
        }

        return $this->redirectToRoute('app_imprimante');
    }
}
