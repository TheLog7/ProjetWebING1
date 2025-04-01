<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331215656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE imprimante (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, modele VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, niveau_encre INT DEFAULT NULL, derniere_interaction DATETIME DEFAULT NULL, salle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4DF2C3AA545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE imprimante');
    }
}
