<?php
namespace App\DataFixtures;

use App\Entity\Thermostat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ThermostatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Créer des thermostats avec des salles aléatoires
        for ($i = 0; $i < 20; $i++) {
            $thermostat = new Thermostat();
            $thermostat->setIdentifiantUnique('Thermo' . $faker->unique()->randomNumber(3));
            $thermostat->setNom('Thermostat ' . $faker->word);
            $thermostat->setTemperatureActuelle($faker->randomFloat(2, 18, 25));
            $thermostat->setTemperatureCible($faker->randomFloat(2, 20, 28));
            $thermostat->setMode($faker->randomElement(['Automatique', 'Manuel', 'Éco']));
            $thermostat->setConnectivite('Wi-Fi, signal ' . $faker->randomElement(['fort', 'moyen', 'faible']));
            $thermostat->setNiveauBatterie($faker->numberBetween(0, 100));
            $thermostat->setDerniereInteraction($faker->dateTimeThisDecade);
            $thermostat->setSalle($this->generateSalleIdentifier($faker));

            $manager->persist($thermostat);
        }

        $manager->flush();
    }

    private function generateSalleIdentifier($faker): string
    {
        $letter = $faker->randomElement(['A', 'B', 'C', 'D', 'E']);
        $number = $faker->randomElement(['05', '10', '15', '20', '25', '30']);
        return $letter . $number;
    }
}
