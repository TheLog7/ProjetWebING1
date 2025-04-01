<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331143529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trottinette (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, niveau_batterie INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, derniere_interaction DATETIME DEFAULT NULL, salle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_44559939545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE velo (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, niveau_batterie INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, derniere_interaction DATETIME DEFAULT NULL, salle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_354971F5545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trottinette');
        $this->addSql('DROP TABLE velo');
    }
}
