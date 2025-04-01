<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401153308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE imprimante (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, modele VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, niveau_batterie INT DEFAULT NULL, niveau_encre INT DEFAULT NULL, derniere_interaction DATETIME DEFAULT NULL, salle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4DF2C3AA545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_trottinette (id INT AUTO_INCREMENT NOT NULL, trottinette_id INT NOT NULL, utilisateur_id INT NOT NULL, date_reservation DATETIME NOT NULL, INDEX IDX_88394465F6798F43 (trottinette_id), INDEX IDX_88394465FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_velo (id INT AUTO_INCREMENT NOT NULL, velo_id INT NOT NULL, utilisateur_id INT NOT NULL, date_reservation DATETIME NOT NULL, INDEX IDX_2370BC9DEC6AC5BD (velo_id), INDEX IDX_2370BC9DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_trottinette ADD CONSTRAINT FK_88394465F6798F43 FOREIGN KEY (trottinette_id) REFERENCES trottinette (id)');
        $this->addSql('ALTER TABLE reservation_trottinette ADD CONSTRAINT FK_88394465FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_velo ADD CONSTRAINT FK_2370BC9DEC6AC5BD FOREIGN KEY (velo_id) REFERENCES velo (id)');
        $this->addSql('ALTER TABLE reservation_velo ADD CONSTRAINT FK_2370BC9DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ordinateur ADD niveau_batterie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trottinette DROP salle');
        $this->addSql('ALTER TABLE velo DROP salle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_trottinette DROP FOREIGN KEY FK_88394465F6798F43');
        $this->addSql('ALTER TABLE reservation_trottinette DROP FOREIGN KEY FK_88394465FB88E14F');
        $this->addSql('ALTER TABLE reservation_velo DROP FOREIGN KEY FK_2370BC9DEC6AC5BD');
        $this->addSql('ALTER TABLE reservation_velo DROP FOREIGN KEY FK_2370BC9DFB88E14F');
        $this->addSql('DROP TABLE imprimante');
        $this->addSql('DROP TABLE reservation_trottinette');
        $this->addSql('DROP TABLE reservation_velo');
        $this->addSql('ALTER TABLE ordinateur DROP niveau_batterie');
        $this->addSql('ALTER TABLE trottinette ADD salle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE velo ADD salle VARCHAR(255) NOT NULL');
    }
}
