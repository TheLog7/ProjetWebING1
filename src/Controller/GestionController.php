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

final class GestionController extends AbstractController
{
    #[Route('/gestion', name: 'app_gestion', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $data = [
            'Livres' => $entityManager->getRepository(Livre::class)->findAll(),
            'Ordinateurs' => $entityManager->getRepository(Ordinateur::class)->findAll(),
            'Imprimantes' => $entityManager->getRepository(Imprimante::class)->findAll(),
            'Vélos' => $entityManager->getRepository(Velo::class)->findAll(),
            'Trottinettes' => $entityManager->getRepository(Trottinette::class)->findAll(),
            'Thermostats' => $entityManager->getRepository(Thermostat::class)->findAll(),
            'Menus' => $entityManager->getRepository(Menu::class)->findAll(),
        ];

        return $this->render('gestion/index.html.twig', [
            'controller_name' => 'GestionController',
            'data' => $data,
        ]);
    }
}
