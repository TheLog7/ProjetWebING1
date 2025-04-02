<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Ordinateur;
use App\Entity\Imprimante;
use App\Entity\Velo;
use App\Entity\Trottinette;
use App\Entity\Thermostat;
use App\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LivreType;
use App\Form\OrdinateurType;
use App\Form\ImprimanteType;
use App\Form\VeloType;
use App\Form\TrottinetteType;
use App\Form\ThermostatType;
use App\Form\MenuType;

final class GestionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/gestion', name: 'app_gestion', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $data = [
            'Livres' => $entityManager->getRepository(Livre::class)->findAll(),
            'Ordinateurs' => $entityManager->getRepository(Ordinateur::class)->findAll(),
            'Imprimantes' => $entityManager->getRepository(Imprimante::class)->findAll(),
            'Vélos' => $entityManager->getRepository(Velo::class)->findAll(),
            'Trottinettes' => $entityManager->getRepository(Trottinette::class)->findAll(),
            'Thermostats' => $entityManager->getRepository(Thermostat::class)->findAll(),
        ];

        return $this->render('gestion/index.html.twig', [
            'controller_name' => 'GestionController',
            'data' => $data,
        ]);
    }
    
    #[Route('/gestion/livre/modifier/{id}', name: 'admin_livre_modifier')]
    public function modifierLivre(Request $request, EntityManagerInterface $entityManager, Livre $livre): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->handleModification($request, $entityManager, $livre, LivreType::class, 'gestion/livre_modifier.html.twig');
    }

    #[Route('/gestion/ordinateur/modifier/{id}', name: 'admin_ordinateur_modifier')]
    public function modifierOrdinateur(Request $request, EntityManagerInterface $entityManager, Ordinateur $ordinateur): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->handleModification($request, $entityManager, $ordinateur, OrdinateurType::class, 'gestion/ordinateur_modifier.html.twig');
    }

    #[Route('/gestion/imprimante/modifier/{id}', name: 'admin_imprimante_modifier')]
    public function modifierImprimante(Request $request, EntityManagerInterface $entityManager, Imprimante $imprimante): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->handleModification($request, $entityManager, $imprimante, ImprimanteType::class, 'gestion/imprimante_modifier.html.twig');
    }

    #[Route('/gestion/velo/modifier/{id}', name: 'admin_velo_modifier')]
    public function modifierVelo(Request $request, EntityManagerInterface $entityManager, Velo $velo): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->handleModification($request, $entityManager, $velo, VeloType::class, 'gestion/velo_modifier.html.twig');
    }

    #[Route('/gestion/trottinette/modifier/{id}', name: 'admin_trottinette_modifier')]
    public function modifierTrottinette(Request $request, EntityManagerInterface $entityManager, Trottinette $trottinette): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->handleModification($request, $entityManager, $trottinette, TrottinetteType::class, 'gestion/trottinette_modifier.html.twig');
    }

    #[Route('/gestion/thermostat/modifier/{id}', name: 'admin_thermostat_modifier')]
    public function modifierThermostat(Request $request, EntityManagerInterface $entityManager, Thermostat $thermostat): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->handleModification($request, $entityManager, $thermostat, ThermostatType::class, 'gestion/thermostat_modifier.html.twig');
    }

    #[Route('/gestion/menu/modifier/{id}', name: 'admin_menu_modifier')]
    public function modifierMenu(Request $request, EntityManagerInterface $entityManager, Menu $menu): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->handleModification($request, $entityManager, $menu, MenuType::class, 'gestion/menu_modifier.html.twig');
    }

    private function handleModification(Request $request, EntityManagerInterface $entityManager, $entity, string $formType, string $template): Response
    {
        $form = $this->createForm($formType, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification enregistrée avec succès.');
            return $this->redirectToRoute('app_gestion');
        }

        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/gestion-objets-defaillants", name:"gestion_objetsDefaillants")]
    public function gestionObjetsDefaillants(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }        $velosDefaillants = $this->entityManager->getRepository(Velo::class)->findByBatterieFaible();
        $trottinettesDefaillantes = $this->entityManager->getRepository(Trottinette::class)->findByBatterieFaible();
        $thermostatsDefaillants = $this->entityManager->getRepository(Thermostat::class)->findByBatterieFaible();
        $imprimantesDefaillantes = $this->entityManager->getRepository(Imprimante::class)->findByBatterieFaible();
        $ordinateursDefaillants = $this->entityManager->getRepository(Ordinateur::class)->findByBatterieFaible();
        $objetsDefaillants = array_merge($velosDefaillants, $trottinettesDefaillantes, $thermostatsDefaillants, $imprimantesDefaillantes, $ordinateursDefaillants);

        return $this->render('gestion/defaillants.html.twig', [
            'objetsDefaillants' => $objetsDefaillants,
        ]);
    }
}
