<?php
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
        'Français' => 4,
        'Histoire-Géographie' => 3,
        'EMC' => 1,
        'Anglais' => 4,
        'Mathématiques' => 4,
        'SVT' => 2,
        'Technologie' => 1,
        'Physique-Chimie' => 2,
    ];

    private $vacances = [
        ['2024-10-19', '2024-11-03'],
        ['2024-12-21', '2025-01-05'],
        ['2025-02-15', '2025-03-02'],
        ['2025-04-12', '2025-04-27']
    ];

    private $joursMapping = [
        'Lundi' => 'monday',
        'Mardi' => 'tuesday',
        'Mercredi' => 'wednesday',
        'Jeudi' => 'thursday',
        'Vendredi' => 'friday'
    ];

    private $creneaux = [
        ['08:00', '09:00'],
        ['09:00', '10:00'],
        ['10:15', '11:15'],
        ['13:30', '14:30'],
        ['14:30', '15:30'],
        ['15:45','16:45'],
    ];

    private $emploiDuTempsProfs = [];

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $classes = ['6eme', '5eme', '4eme', '3eme'];
        
        foreach ($classes as $classe) {
            $this->genererEmploiDuTempsAnnuel($manager, $classe);
        }

        $manager->flush();
    }

    private function genererEmploiDuTempsAnnuel(ObjectManager $manager, string $classe): void
    {
        $debutAnnee = new \DateTime('2024-09-02');
        $finAnnee = new \DateTime('2025-06-30');

        $edtType1 = $this->genererEDTType($manager, $classe);
        $edtType2 = $this->genererEDTType($manager, $classe);

        $semaine = clone $debutAnnee;
        $alternance = false;
        while ($semaine <= $finAnnee) {
            if (!$this->estEnVacances($semaine)) {
                $this->appliquerEDTType(
                    $manager, 
                    $alternance ? $edtType2 : $edtType1, 
                    $semaine, 
                    $classe
                );
                $alternance = !$alternance;
            }
            $semaine->modify('+1 week');
        }
    }
    

    private function genererEDTType(ObjectManager $manager, string $classe): array
    {
        $edt = [];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        
        $enseignants = $manager->getRepository(Utilisateur::class)->findBy(['type' => 'Enseignant']);
        
        $coursParMatiere = [];
        foreach ($this->matieres as $matiere => $nbHeures) {
            foreach ($enseignants as $prof) {
                if ($prof->getMatiere() === $matiere) {
                    for ($i = 0; $i < $nbHeures; $i++) {
                        $coursParMatiere[] = [
                            'matiere' => $matiere,
                            'profId' => $prof->getId()
                        ];
                    }
                    break; 
                }
            }
        }
        shuffle($coursParMatiere);

        foreach ($jours as $jour) {
            $edt[$jour] = [];
            $creneauxDispos = $this->creneaux;
            shuffle($creneauxDispos);
            
            while (!empty($coursParMatiere) && !empty($creneauxDispos)) {
                $cours = array_shift($coursParMatiere);
                $creneau = array_shift($creneauxDispos);
                
                $edt[$jour][] = [
                    'matiere' => $cours['matiere'],
                    'profId' => $cours['profId'],
                    'creneau' => $creneau
                ];
            }
        }

        return $edt;
    }

    private function appliquerEDTType(ObjectManager $manager, array $edtType, \DateTime $lundi, string $classe): void
    {
        foreach ($edtType as $jourFr => $coursJour) {
            $jourEn = $this->joursMapping[$jourFr];
            $date = $jourFr === 'Lundi' 
                ? clone $lundi 
                : (clone $lundi)->modify($jourEn);

            foreach ($coursJour as $cours) {
                $prof = $manager->getRepository(Utilisateur::class)->find($cours['profId']);
                $this->creerCours(
                    $manager,
                    $prof,
                    $classe,
                    $cours['matiere'],
                    $date,
                    $cours['creneau']
                );
            }
        }
    }

    private function creerCours(
        ObjectManager $manager,
        Utilisateur $enseignant,
        string $classe,
        string $matiere,
        \DateTimeInterface $dateJour,
        array $creneau
    ): void {
        $dateConcrete = \DateTime::createFromFormat('Y-m-d H:i:s', $dateJour->format('Y-m-d H:i:s'));
        
        $salle = $this->faker->randomElement(['A','B','C']) 
                . $this->faker->randomElement(['05','10','15','20','25','30']);

        $debut = clone $dateConcrete;
        list($heureDebut, $minuteDebut) = explode(':', $creneau[0]);
        $debut->setTime($heureDebut, $minuteDebut);
        
        $fin = clone $dateConcrete;
        list($heureFin, $minuteFin) = explode(':', $creneau[1]);
        $fin->setTime($heureFin, $minuteFin);

        $profId = $enseignant->getId();
        if (isset($this->emploiDuTempsProfs[$profId])) {
            foreach ($this->emploiDuTempsProfs[$profId] as $coursExist) {
                if (($debut >= $coursExist['debut'] && $debut < $coursExist['fin']) ||
                    ($fin > $coursExist['debut'] && $fin <= $coursExist['fin'])) {
                    return; 
                }
            }
        }

        $cours = new Cours();
        $cours->setMatiere($matiere)
              ->setEnseignant($enseignant)
              ->setClasse($classe)
              ->setSalle($salle)
              ->setDebut($debut)
              ->setFin($fin);

        $manager->persist($cours);
        
        if (!isset($this->emploiDuTempsProfs[$profId])) {
            $this->emploiDuTempsProfs[$profId] = [];
        }
        $this->emploiDuTempsProfs[$profId][] = ['debut' => $debut, 'fin' => $fin];
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