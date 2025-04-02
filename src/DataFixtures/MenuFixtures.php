<?php
namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $year = 2025;

        $entrees = [
            'Salade César', 'Soupe de légumes', 'Terrine de foie gras', 'Tartare de saumon',
            'Salade de chèvre chaud', 'Bruschetta', 'Carpaccio de bœuf', 'Velouté de potiron',
            'Salade de betteraves', 'Crevettes sautées'
        ];

        $plats = [
            'Boeuf bourguignon', 'Poulet rôti', 'Chili con carne', 'Lasagne', 'Gratin dauphinois',
            'Poisson meunière', 'Steak frites', 'Côtelettes d\'agneau', 'Curry de poulet',
            'Filet de saumon', 'Risotto aux champignons', 'Paella', 'Coq au vin', 'Ratatouille',
            'Blanquette de veau'
        ];

        $desserts = [
            'Crêpes Suzette', 'Tarte au chocolat', 'Panna cotta', 'Mousse au chocolat',
            'Tarte aux pommes', 'Fondant au chocolat', 'Tiramisu', 'Clafoutis aux cerises',
            'Glace à la vanille', 'Soufflé au Grand Marnier', 'Crème brûlée', 'Tarte Tatin',
            'Bavarois aux fruits', 'Gâteau au yaourt', 'Îles flottantes'
        ];

        $vacances = [
            '2025-02-15' => '2025-03-03',
            '2025-04-26' => '2025-05-12',
            '2025-07-05' => '2025-09-01',
            '2025-10-19' => '2025-11-03',
            '2025-12-20' => '2025-01-05'
        ];

        $startDate = new \DateTime("$year-01-01");
        $endDate = new \DateTime("$year-12-31");
        $interval = new \DateInterval('P1D'); 
        $datePeriod = new \DatePeriod($startDate, $interval, $endDate);

        foreach ($datePeriod as $date) {
            $dayOfWeek = $date->format('N');
            $dateString = $date->format('Y-m-d');

            if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && !$this->isInVacances($dateString, $vacances)) {
                $menu = new Menu();
                $menu->setDate($date);
                $menu->setEntree($entrees[array_rand($entrees)]);
                $menu->setPlat($plats[array_rand($plats)]);
                $menu->setDessert($desserts[array_rand($desserts)]);

                $manager->persist($menu);
            }
        }

        $manager->flush();
    }

    private function isInVacances($date, $vacances) {
        foreach ($vacances as $start => $end) {
            if ($date >= $start && $date <= $end) {
                return true;
            }
        }
        return false;
    }
}
