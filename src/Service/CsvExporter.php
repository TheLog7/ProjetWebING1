<?php

// src/Service/CsvExporter.php

namespace App\Service;

class CsvExporter
{
    public function export($data)
    {
        $output = fopen('php://output', 'w');
        // En-tête du CSV
        fputcsv($output, ['ID', 'Nom', 'Email', 'Date d\'inscription']);
        
        foreach ($data as $item) {
            fputcsv($output, [
                $item->getId(),
                $item->getNom(),
                $item->getEmail(),
                $item->getType()
            ]);
        }
        
        fclose($output);
    }
}
