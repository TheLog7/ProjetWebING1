<?php

namespace App\DataFixtures;

use App\Entity\Imprimante;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ImprimanteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 7; $i++) {
            $imprimante = new Imprimante();
            $imprimante->setIdentifiantUnique('IMP' . $faker->unique()->randomNumber(4));
            $imprimante->setNom('Imprimante ' . $faker->word);
            $imprimante->setModele($faker->word);
            $imprimante->setStatut($faker->randomElement(['Disponible', 'En maintenance', 'Hors service']));
            $imprimante->setNiveauBatterie($faker->numberBetween(0, 100));
            $imprimante->setNiveauEncre($faker->numberBetween(0, 100));
            $imprimante->setDerniereInteraction($faker->dateTimeThisDecade);
            $imprimante->setSalle($this->generateSalle($faker));

            $manager->persist($imprimante);
        }

        $manager->flush();
    }
    private function generateSalle($faker): string
    {
        $letter = $faker->randomElement(['A', 'B', 'C', 'D', 'E']);
        $number = $faker->randomElement(['05', '10', '15', '20', '25', '30']);
        return $letter . $number;
    }

}
