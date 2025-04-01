<?php 
namespace App\DataFixtures;

use App\Entity\Trottinette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TrottinetteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $trottinette = new Trottinette();
            $trottinette->setIdentifiantUnique('Trottinette' . $faker->unique()->randomNumber(3));
            $trottinette->setNom('Trottinette ' . $faker->word);
            $trottinette->setMarque($faker->company);
            $trottinette->setNiveauBatterie($faker->numberBetween(0, 100));
            $trottinette->setStatut($faker->randomElement(['Disponible', 'Réservé', 'En maintenance']));
            $trottinette->setDerniereInteraction($faker->dateTimeThisDecade);
            $trottinette->setSalle($faker->randomElement(['A05', 'B10', 'C15']));

            $manager->persist($trottinette);
        }

        $manager->flush();
    }
}
