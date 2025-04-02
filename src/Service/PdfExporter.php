<?php

// src/Service/PdfExporter.php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfExporter
{
    public function export($data)
    {
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        $html = '<h1>Rapport des Utilisateurs</h1><table border="1"><thead><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Type</th><th>Age</th><th>Sexe</th><th>Niveau</th><th>Points</th><th>Valide</th></tr></thead><tbody>';

        foreach ($data as $item) {
            $html .= '<tr>
                        <td>' . $item->getId() . '</td>
                        <td>' . $item->getNom() . '</td>
                        <td>' . $item->getPrenom() . '</td>
                        <td>' . $item->getEmail() . '</td>
                        <td>' . $item->getType() . '</td>
                        <td>' . $item->getAge() . '</td>
                        <td>' . $item->getSexe() . '</td>
                        <td>' . $item->getNiveau() . '</td>
                        <td>' . $item->getPoints() . '</td>
                        <td>' . $item->isValide() . '</td>
                      </tr>';
        }

        $html .= '</tbody></table>';

        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output();
    }
}
