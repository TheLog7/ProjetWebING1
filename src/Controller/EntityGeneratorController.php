<?php

namespace App\Controller;

use App\Form\EntityGeneratorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Process;

#[Route('/admin/entity')]
class EntityGeneratorController extends AbstractController
{
    #[Route('/create', name: 'admin_entity_create')]
    public function createEntity(Request $request): Response
    {
        $form = $this->createForm(EntityGeneratorType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityName = ucfirst(trim($data['nom'])); // Capitaliser et nettoyer le nom
            $attributes = array_filter(array_map('trim', explode(',', $data['attributs']))); // Nettoyage

            // --- Debug : Afficher les valeurs reçues ---
            dump($entityName);
            dump($attributes);

            // Créer le répertoire de l'entité si nécessaire
            $entityDir = 'src/Entity/';
            if (!file_exists($entityDir)) {
                mkdir($entityDir, 0777, true);
                dump('Répertoire src/Entity/ créé');
            }

            // Définir le chemin de l'entité à créer
            $entityPath = $entityDir . $entityName . '.php';
            $entityTemplate = "<?php\n\nnamespace App\Entity;\n\nuse Doctrine\ORM\Mapping as ORM;\n\n#[ORM\Entity]\nclass {$entityName}\n{\n";

            // Ajouter les attributs à l'entité
            foreach ($attributes as $attribute) {
                $parts = explode(':', trim($attribute));

                if (count($parts) === 2) {
                    $property = $parts[0];
                    $type = $parts[1];

                    // Ajouter une propriété à l'entité
                    $entityTemplate .= "    #[ORM\Column(type: '{$type}')]\n";
                    $entityTemplate .= "    private ?{$type} \${$property} = null;\n\n";
                }
            }

            // Fermeture de la classe
            $entityTemplate .= "}\n";

            // Écrire le fichier de l'entité
            if (file_put_contents($entityPath, $entityTemplate)) {
                dump("Fichier de l'entité créé avec succès à : {$entityPath}");
            } else {
                dump('Erreur lors de la création du fichier de l\'entité');
            }

            // --- Exécuter la commande pour générer la migration ---
            $process = new Process(['php', 'bin/console', 'make:migration']);
            $process->run();
            dump('Commande make:migration exécutée');

            // Vérifie si la commande de migration a réussi
            if (!$process->isSuccessful()) {
                dump('Erreur lors de la création de la migration');
    dump($process->getErrorOutput()); // Affiche l'erreur retournée par la commande
                $this->addFlash('error', "Erreur lors de la création de la migration.");
                return $this->redirectToRoute('admin_entity_create');
            }

            // --- Appliquer la migration ---
            $migrateProcess = new Process(['php', 'bin/console', 'doctrine:migrations:migrate', '--no-interaction']);
            $migrateProcess->run();
            dump('Commande doctrine:migrations:migrate exécutée');

            if (!$migrateProcess->isSuccessful()) {
                dump('Erreur lors de l\'application de la migration');
                $this->addFlash('error', "Erreur lors de l'application de la migration.");
                return $this->redirectToRoute('admin_entity_create');
            }

            // Si tout est réussi
            $this->addFlash('success', "L'entité {$entityName} a été créée avec succès !");
            
            // ✅ Redirection après soumission pour éviter le bug Turbo
            return $this->redirectToRoute('admin_entity_create');
        }

        return $this->render('entity_generator/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
