<?php
namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Matières avec répartition réaliste
        $matieresEnseignants = [
            'Mathématiques' => 2,    
            'Français' => 2,
            'Anglais' => 2,
            'Histoire-Géographie' => 1,
            'EMC' => 1,              
            'SVT' => 1,
            'Technologie' => 1,
            'Physique-Chimie' => 1,
            'EPS' => 2,               
            'Arts plastiques' => 1,
            'Éducation musicale' => 1,
            'Orientation' => 1,
            'Révisions' => 1,
            "LV2" => 1,
        ];

        $classes = ['6eme', '5eme', '4eme', '3eme'];

        // Création des enseignants (15 au total)
        foreach ($matieresEnseignants as $matiere => $nombre) {
            for ($i = 0; $i < $nombre; $i++) {
                $enseignant = new Utilisateur();
                $prenom = $faker->firstName;
                $nom = $faker->lastName;
                
                $enseignant->setNom($nom);
                $enseignant->setPrenom($prenom);
                $enseignant->setEmail(strtolower($prenom.'.'.$nom.'@ecole.fr')); 
                $enseignant->setType('Enseignant');
                $enseignant->setPassword($this->passwordHasher->hashPassword($enseignant, 'prof123')); 
                $enseignant->setAge($faker->numberBetween(28, 55));
                $enseignant->setSexe($faker->randomElement(['Homme', 'Femme']));
                $enseignant->setMatiere($matiere);
                $enseignant->setPhoto('default_teacher.png');
                $manager->persist($enseignant);
                
                // Référence pour les cours
                $this->addReference('enseignant_'.$matiere.'_'.$i, $enseignant);
            }
        }
        
        
        // Création des élèves (~25 par niveau)
        foreach ($classes as $classe) {
            for ($i = 1; $i <= 25; $i++) {
                $eleve = new Utilisateur();
                $eleve->setNom($faker->lastName);
                $eleve->setPrenom($faker->firstName);
                $eleve->setEmail('eleve'.$i.'.'.$classe.'@ecole.fr');
                $eleve->setType('Eleve');
                $eleve->setPassword($this->passwordHasher->hashPassword($eleve, 'eleve123'));
                $eleve->setAge($this->getAgeByClasse($classe));
                $eleve->setSexe($faker->randomElement(['Homme', 'Femme']));
                $eleve->setClasse($classe);
                $eleve->setPhoto('default_student.png');
                $eleve->setNiveau(1); // Niveau de départ
                $eleve->setPoints(0);
                $manager->persist($eleve);
            }
        }

        // Création des admins (3 au total)
        $admins = [
            ['nom' => 'Admin', 'prenom' => 'Principal', 'email' => 'principal@ecole.fr'],
            ['nom' => 'Admin', 'prenom' => 'Secretariat', 'email' => 'secretariat@ecole.fr'],
            ['nom' => 'Admin', 'prenom' => 'Technique', 'email' => 'tech@ecole.fr']
        ];

        foreach ($admins as $adminData) {
            $admin = new Utilisateur();
            $admin->setNom($adminData['nom']);
            $admin->setPrenom($adminData['prenom']);
            $admin->setEmail($adminData['email']);
            $admin->setType('Administration');
            $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
            $admin->setAge($faker->numberBetween(30, 50));
            $admin->setSexe($faker->randomElement(['Homme', 'Femme']));
            $admin->setPhoto('default_admin.png');
            $manager->persist($admin);
        }

        $manager->flush();
    }

    private function getAgeByClasse(string $classe): int
    {
        // Âge moyen par classe
        $ages = [
            '6ème' => 11,
            '5ème' => 12,
            '4ème' => 13,
            '3ème' => 14
        ];
        
        return $ages[$classe] ?? 12;
    }
}