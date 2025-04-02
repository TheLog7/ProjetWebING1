<?php

namespace App\DataFixtures;

use App\Entity\Ordinateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrdinateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 7; $i++) {
            $ordinateur = new Ordinateur();
            $ordinateur->setNom('Ordinateur ' . $faker->word);
            $ordinateur->setMarque($faker->company);
            $ordinateur->setNumeroSerie($faker->unique()->regexify('[A-Z0-9]{10}'));
            $ordinateur->setStatus($faker->randomElement(['Disponible', 'En maintenance', 'Hors service', 'Indisponible']));
            $ordinateur->setLocalisation($this->generateLocalisation($faker));       
            $ordinateur->setNiveauBatterie($faker->optional()->numberBetween(0, 100));
            $ordinateur->setDateAchat($faker->dateTimeBetween('-5 years', 'now'));
            $ordinateur->setDerniereMaintenance(derniere_maintenance: $faker->optional()->dateTimeBetween('-2 years', 'now'));
            $ordinateur->setEstEnService($faker->boolean);

            $manager->persist($ordinateur);
        }

        $manager->flush();
    }

    
    private function generateLocalisation($faker): string
    {
        $letter = $faker->randomElement(['Salle A', 'Salle B', 'Salle C', 'Salle D','Bureau ']);
        $number = $faker->randomElement(['05', '10', '15', '20', '25', '30']);
        return $letter . $number;
    }
}