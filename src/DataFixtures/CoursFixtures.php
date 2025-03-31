<?php
// src/DataFixtures/CoursFixtures.php
namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class CoursFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
    private $matieres = [
        'EPS' => 4,
        'Arts plastiques' => 1,
        'Éducation musicale' => 1,
        'Français' => 4.5,
        'Histoire-Géographie' => 1.5,
        'EMC' => 1.5,
        'Anglais' => 4,
        'Mathématiques' => 4.5,
        'SVT' => 1.33,
        'Technologie' => 1.33,
        'Physique-Chimie' => 1.34
    ];

    // Vacances scolaires Zone C
    private $vacances = [
        ['2024-10-19', '2024-11-03'],
        ['2024-12-21', '2025-01-05'],
        ['2025-02-15', '2025-03-02'],
        ['2025-04-12', '2025-04-27']
    ];

    // Mapping des jours en français vers anglais
    private $joursMapping = [
        'Lundi' => 'monday',
        'Mardi' => 'tuesday',
        'Mercredi' => 'wednesday',
        'Jeudi' => 'thursday',
        'Vendredi' => 'friday'
    ];

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $enseignants = $manager->getRepository(Utilisateur::class)->findBy(['type' => 'Enseignant']);
        $classes = ['6ème', '5ème', '4ème', '3ème'];

        $profsParClasse = $this->assignerProfs($enseignants, $classes);

        foreach ($classes as $classe) {
            $this->genererEmploiDuTempsAnnuel($manager, $profsParClasse[$classe], $classe);
        }

        $manager->flush();
    }

    private function assignerProfs(array $enseignants, array $classes): array
    {
        $assignations = [];
        shuffle($enseignants);

        foreach ($classes as $classe) {
            $i = 0;
            foreach ($this->matieres as $matiere => $h) {
                $assignations[$classe][$matiere] = $enseignants[$i % count($enseignants)];
                $i++;
            }
        }
        return $assignations;
    }

    private function genererEmploiDuTempsAnnuel(ObjectManager $manager, array $profsClasse, string $classe): void
    {
        $debutAnnee = new \DateTime('2024-09-02');
        $finAnnee = new \DateTime('2025-06-30');

        $semaine = clone $debutAnnee;
        while ($semaine <= $finAnnee) {
            if (!$this->estEnVacances($semaine)) {
                $this->genererSemaine($manager, $profsClasse, $classe, $semaine);
            }
            $semaine->modify('+1 week');
        }
    }

    private function genererSemaine(ObjectManager $manager, array $profsClasse, string $classe, \DateTime $lundi): void
    {
        $emploiType = [
            'Lundi' => ['Mathématiques', 'Français', 'Anglais', 'EPS'],
            'Mardi' => ['Histoire-Géographie', 'EMC', 'SVT', 'Technologie'],
            'Mercredi' => ['Français', 'Arts plastiques', 'Physique-Chimie'],
            'Jeudi' => ['Mathématiques', 'Anglais', 'Éducation musicale'],
            'Vendredi' => ['EPS', 'Français', 'Mathématiques']
        ];

        foreach ($emploiType as $jourFr => $matieres) {
            $jourEn = $this->joursMapping[$jourFr];
            $date = $jourFr === 'Lundi' 
                ? clone $lundi 
                : (clone $lundi)->modify($jourEn);

            foreach ($matieres as $matiere) {
                $this->creerCours(
                    $manager,
                    $profsClasse[$matiere],
                    $classe,
                    $matiere,
                    $this->matieres[$matiere] / count($emploiType[$jourFr]),
                    $date
                );
            }
        }
    }

    private function creerCours(
        ObjectManager $manager,
        Utilisateur $enseignant,
        string $classe,
        string $matiere,
        float $dureeHeures,
        \DateTimeInterface $dateJour
    ): void {
        // Conversion en DateTime concret pour utiliser setTime()
        $dateConcrete = \DateTime::createFromFormat('Y-m-d H:i:s', $dateJour->format('Y-m-d H:i:s'));
        
        // Génération de la salle
        $salle = $this->faker->randomElement(['A','B','C']) 
                . $this->faker->randomElement(['05','10','15','20','25','30']);
    
        // Conversion de la durée
        $heures = (int)floor($dureeHeures);
        $minutes = (int)round(($dureeHeures - $heures) * 60);
    
        // Début aléatoire entre 8h et 16h
        $debut = (clone $dateConcrete)->setTime(
            $this->faker->numberBetween(8, 16),
            $this->faker->randomElement([0, 30])
        );
        
        $fin = (clone $debut)->modify("+{$heures} hours +{$minutes} minutes");
    
        // Ajustement si chevauchement avec la pause déjeuner
        if ($debut->format('H:i') < '12:00' && $fin->format('H:i') > '12:00') {
            $debut->setTime(13, 30);
            $fin = (clone $debut)->modify("+{$heures} hours +{$minutes} minutes");
        }
    
        $cours = new Cours();
        $cours->setMatiere($matiere)
              ->setEnseignant($enseignant)
              ->setClasse($classe)
              ->setSalle($salle)
              ->setDebut($debut)
              ->setFin($fin);
    
        $manager->persist($cours);
    }
    private function estEnVacances(\DateTimeInterface $date): bool
    {
        foreach ($this->vacances as $periode) {
            $debut = new \DateTime($periode[0]);
            $fin = new \DateTime($periode[1]);
            if ($date >= $debut && $date <= $fin) {
                return true;
            }
        }
        return false;
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}