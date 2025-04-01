<?php

namespace App\Controller;

use App\Entity\Thermostat;
use App\Form\ThermostatType;
use App\Repository\ThermostatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ThermostatController extends AbstractController
{
    #[Route('/thermostats', name: 'app_thermostat')]
    public function index(Request $request, ThermostatRepository $thermostatRepository): Response
    {
        $thermostats = $thermostatRepository->findAll();

        return $this->render('thermostat/index.html.twig', [
            'thermostats' => $thermostats,
        ]);
    }

    #[Route('/thermostats/ajout', name: 'app_thermostat_ajout')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $thermostat = new Thermostat();
        $form = $this->createForm(ThermostatType::class, $thermostat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($thermostat);
            $entityManager->flush();

            $this->addFlash('success', 'Thermostat ajouté avec succès !');
            return $this->redirectToRoute('app_thermostat');
        }

        return $this->render('thermostat/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/thermostats/{id}', name: 'app_thermostat_details', requirements: ['id' => '\d+'])]
    public function details(Thermostat $thermostat): Response
    {
        return $this->render('thermostat/details.html.twig', [
            'thermostat' => $thermostat,
        ]);
    }

    #[Route('/thermostat/{id}/supprimer', name: 'app_thermostat_supprimer')]
    public function supprimer(Thermostat $thermostat, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($this->getUser()->getType() === 'Administration' || $this->getUser()->getNiveau() === 3) {
            $entityManager->remove($thermostat);
            $entityManager->flush();

            $this->addFlash('success', 'Thermostat supprimé avec succès !');
        } else {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer ce thermostat.');
        }

        return $this->redirectToRoute('app_thermostat');
    }
}
