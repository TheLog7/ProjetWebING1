<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331132510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE thermostat (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, temperature_actuelle DOUBLE PRECISION DEFAULT NULL, temperature_cible DOUBLE PRECISION DEFAULT NULL, mode VARCHAR(255) DEFAULT NULL, connectivite VARCHAR(255) DEFAULT NULL, niveau_batterie INT DEFAULT NULL, derniere_interaction DATETIME DEFAULT NULL, salle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B69BDDD0545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE thermostat');
    }
}
