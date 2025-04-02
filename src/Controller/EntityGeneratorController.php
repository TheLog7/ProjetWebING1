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
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        $form = $this->createForm(EntityGeneratorType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityName = ucfirst(trim($data['nom'])); 
            $attributes = array_filter(array_map('trim', explode(',', $data['attributs']))); 

            dump($entityName);
            dump($attributes);

            $entityDir = 'src/Entity/';
            if (!file_exists($entityDir)) {
                mkdir($entityDir, 0777, true);
                dump('Répertoire src/Entity/ créé');
            }

            $entityPath = $entityDir . $entityName . '.php';
            $entityTemplate = "<?php\n\nnamespace App\Entity;\n\nuse Doctrine\ORM\Mapping as ORM;\n\n#[ORM\Entity]\nclass {$entityName}\n{\n";

            foreach ($attributes as $attribute) {
                $parts = explode(':', trim($attribute));

                if (count($parts) === 2) {
                    $property = $parts[0];
                    $type = $parts[1];

                    $entityTemplate .= "    #[ORM\Column(type: '{$type}')]\n";
                    $entityTemplate .= "    private ?{$type} \${$property} = null;\n\n";
                }
            }

            $entityTemplate .= "}\n";

            if (file_put_contents($entityPath, $entityTemplate)) {
                dump("Fichier de l'entité créé avec succès à : {$entityPath}");
            } else {
                dump('Erreur lors de la création du fichier de l\'entité');
            }

            $process = new Process(['php', 'bin/console', 'make:migration']);
            $process->run();
            dump('Commande make:migration exécutée');

            if (!$process->isSuccessful()) {
                dump('Erreur lors de la création de la migration');
                dump($process->getErrorOutput()); 
                $this->addFlash('error', "Erreur lors de la création de la migration.");
                return $this->redirectToRoute('admin_entity_create');
            }

            $migrateProcess = new Process(['php', 'bin/console', 'doctrine:migrations:migrate', '--no-interaction']);
            $migrateProcess->run();
            dump('Commande doctrine:migrations:migrate exécutée');

            if (!$migrateProcess->isSuccessful()) {
                dump('Erreur lors de l\'application de la migration');
                $this->addFlash('error', "Erreur lors de l'application de la migration.");
                return $this->redirectToRoute('admin_entity_create');
            }

            $this->addFlash('success', "L'entité {$entityName} a été créée avec succès !");
            
            return $this->redirectToRoute('admin_entity_create');
        }

        return $this->render('entity_generator/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
