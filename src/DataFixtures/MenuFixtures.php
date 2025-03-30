<?php
// src/DataFixtures/MenuFixtures.php
namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Année configurable
        $year = 2025;

        // Listes de plats pour générer des menus
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

        // Périodes de vacances scolaires pour l'académie de Paris en 2025
        $vacances = [
            // Vacances d'hiver
            '2025-02-15' => '2025-03-03',
            // Vacances de printemps
            '2025-04-26' => '2025-05-12',
            // Vacances d'été
            '2025-07-05' => '2025-09-01',
            // Vacances de la Toussaint
            '2025-10-19' => '2025-11-03',
            // Vacances de Noël
            '2025-12-20' => '2025-01-05'
        ];

        // Générer des dates pour chaque jour ouvré de l'année
        $startDate = new \DateTime("$year-01-01");
        $endDate = new \DateTime("$year-12-31");
        $interval = new \DateInterval('P1D'); // Intervalle de 1 jour
        $datePeriod = new \DatePeriod($startDate, $interval, $endDate);

        foreach ($datePeriod as $date) {
            // Vérifier si le jour est un jour ouvré (lundi à vendredi) et non en vacances
            $dayOfWeek = $date->format('N');
            $dateString = $date->format('Y-m-d');

            if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && !$this->isInVacances($dateString, $vacances)) {
                // Générer des plats aléatoires pour chaque jour ouvré
                $menu = new Menu();
                $menu->setDate($date);
                $menu->setEntree($entrees[array_rand($entrees)]);
                $menu->setPlat($plats[array_rand($plats)]);
                $menu->setDessert($desserts[array_rand($desserts)]);

                // Persister le menu
                $manager->persist($menu);
            }
        }

        // Sauvegarder tous les menus dans la base de données
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
