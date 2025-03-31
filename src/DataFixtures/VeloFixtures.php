<?php
namespace App\DataFixtures;

use App\Entity\Velo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VeloFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $velo = new Velo();
            $velo->setIdentifiantUnique('Velo' . $faker->unique()->randomNumber(3));
            $velo->setNom('Velo ' . $faker->word);
            $velo->setMarque($faker->company);
            $velo->setNiveauBatterie($faker->numberBetween(0, 100));
            $velo->setStatut($faker->randomElement(['Disponible', 'Réservé', 'En maintenance']));
            $velo->setDerniereInteraction($faker->dateTimeThisDecade);
            $velo->setSalle($faker->randomElement(['A05', 'B10', 'C15']));

            $manager->persist($velo);
        }

        $manager->flush();
    }
}
