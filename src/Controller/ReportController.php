<?php


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
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $users = $this->userRepository->findAll();

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
        $velos = $veloRepository->findAll();
        $trottinettes = $trottinetteRepository->findAll();
        $thermostats = $thermostatRepository->findAll();
        $imprimantes = $imprimanteRepository->findAll();
        $ordinateurs = $ordinateurRepository->findAll();

        $html = $this->renderView('gestion/rapport_pdf.html.twig', [
            'velos' => $velos,
            'trottinettes' => $trottinettes,
            'thermostats' => $thermostats,
            'imprimantes' => $imprimantes,
            'ordinateurs' => $ordinateurs,
        ]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $pdf = $dompdf->output();

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="rapport_objets.pdf"',
        ]);
    }
}
