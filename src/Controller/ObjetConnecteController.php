<?php

namespace App\Controller;

use App\Entity\Thermostat;
use App\Entity\Velo;
use App\Entity\Trottinette;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ObjetConnecteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/objet', name: 'app_objet_connecte')]
    public function index(): Response
    {
        // Récupérer tous les objets sans filtrage
        $thermostats = $this->entityManager
            ->getRepository(Thermostat::class)
            ->findAll();
    
        $velos = $this->entityManager
            ->getRepository(Velo::class)
            ->findAll();
    
        $trottinettes = $this->entityManager
            ->getRepository(Trottinette::class)
            ->findAll();
    
        return $this->render('objet_connecte/index.html.twig', [
            'thermostats' => $thermostats,
            'velos' => $velos,
            'trottinettes' => $trottinettes,
        ]);
    }
}