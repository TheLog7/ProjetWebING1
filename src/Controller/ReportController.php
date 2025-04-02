<?php

// src/Controller/ReportController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;
use App\Service\CsvExporter;
use App\Service\PdfExporter;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\VeloRepository;
use App\Repository\TrottinetteRepository;
use App\Repository\ThermostatRepository;
use App\Repository\ImprimanteRepository;
use App\Repository\OrdinateurRepository;

class ReportController extends AbstractController
{
    private UtilisateurRepository $userRepository;
    private CsvExporter $csvExporter;
    private PdfExporter $pdfExporter;

    public function __construct(UtilisateurRepository $userRepository, CsvExporter $csvExporter, PdfExporter $pdfExporter)
    {
        $this->userRepository = $userRepository;
        $this->csvExporter = $csvExporter;
        $this->pdfExporter = $pdfExporter;
    }

    #[Route('/admin/report/export/{format}', name: 'admin_report_export')]
    public function exportReport(string $format): Response
    {
        // Récupération des données à exporter
        $users = $this->userRepository->findAll();

        // Export CSV
        if ($format === 'csv') {
            $csvData = $this->csvExporter->export($users);
            return new Response(
                $csvData,
                200,
                [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="report.csv"'
                ]
            );
        }

        // Export PDF
        if ($format === 'pdf') {
            $pdfContent = $this->pdfExporter->export($users);
            return new Response(
                $pdfContent,
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="report.pdf"'
                ]
            );
        }

        // Format inconnu
        return new Response('Format non supporté', 400);
    }

    #[Route("/generer-rapport-pdf", name:"generer_rapport_pdf")]  
    public function genererRapport(
        VeloRepository $veloRepository,
        TrottinetteRepository $trottinetteRepository,
        ThermostatRepository $thermostatRepository,
        ImprimanteRepository $imprimanteRepository,
        OrdinateurRepository $ordinateurRepository
    ): Response {
        // Récupérer tous les objets par catégorie
        $velos = $veloRepository->findAll();
        $trottinettes = $trottinetteRepository->findAll();
        $thermostats = $thermostatRepository->findAll();
        $imprimantes = $imprimanteRepository->findAll();
        $ordinateurs = $ordinateurRepository->findAll();

        // Générer le contenu HTML pour le rapport
        $html = $this->renderView('gestion/rapport_pdf.html.twig', [
            'velos' => $velos,
            'trottinettes' => $trottinettes,
            'thermostats' => $thermostats,
            'imprimantes' => $imprimantes,
            'ordinateurs' => $ordinateurs,
        ]);

        // Configuration de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Initialisation de Dompdf
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // (Optionnel) Définir le format du papier
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du PDF
        $dompdf->render();

        // Retourner le PDF en réponse
        $pdf = $dompdf->output();

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="rapport_objets.pdf"',
        ]);
    }
}
