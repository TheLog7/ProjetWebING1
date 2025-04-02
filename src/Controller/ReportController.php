<?php

// src/Controller/ReportController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;
use App\Service\CsvExporter;
use App\Service\PdfExporter;

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
}
