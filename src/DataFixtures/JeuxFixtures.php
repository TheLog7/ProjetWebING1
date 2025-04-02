<?php

namespace App\DataFixtures;

use App\Entity\Jeux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JeuxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $objects = [
            ['name' => 'Babyfoot 1', 'type' => 'babyfoot', 'slots' => 4],
            ['name' => 'Babyfoot 2', 'type' => 'babyfoot', 'slots' => 4],
            ['name' => 'PlayStation 5', 'type' => 'playstation', 'slots' => 2]
        ];

        foreach ($objects as $data) {
            $object = new Jeux();
            $object->setName($data['name'])
                  ->setType($data['type'])
                  ->setMaxPlaces($data['slots'])
                  ->setDescription('Réservation par créneau de 1h');
            $manager->persist($object);
        }

        $manager->flush();
    }
}
