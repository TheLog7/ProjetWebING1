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

        $html = '<h1>Rapport des utilisateurs</h1><table border="1"><thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Date d\'inscription</th></tr></thead><tbody>';

        foreach ($data as $item) {
            $html .= '<tr>
                        <td>' . $item->getId() . '</td>
                        <td>' . $item->getNom() . '</td>
                        <td>' . $item->getEmail() . '</td>
                        <td>' . $item->getType() . '</td>
                      </tr>';
        }

        $html .= '</tbody></table>';

        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output();
    }
}
